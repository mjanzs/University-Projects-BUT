<?php

class EmployeeController extends Controller
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('index', 'view'),
                'users' => Yii::app()->user->getAdmins(),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'create', 'update'),
                'users' => Yii::app()->user->getSuperAdmins(),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $user = new Usr;
        $employee = new Employee;
        $address = new Address;
        $models = array($user, $employee, $address);
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($models);

        $this->saveModels($models);

        $this->render('create', array(
            'user' => $user,
            'employee' => $employee,
            'address' => $address
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $user = Usr::model()->findByPk($id);
        $employee = $this->loadModel($id);
        $address = $employee->address_id == null ? new Address : Address::model()->findByPk($employee->address_id);
        $models = array($user, $employee, $address);
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($models);

        $this->saveModels($models, false);

        $this->render('update', array(
            'user' => $user,
            'employee' => $employee,
            'address' => $address
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {

        if (Borrowing::model()->findAllByAttributes(array('employee_id_take' => $id)) == array() && 
            Borrowing::model()->findAllByAttributes(array('employee_id_lend' => $id)) == array()) {
            
            $this->loadModel($id)->delete();
        }
        else {
            $text = 'Na zaměstnanece jsou vedeny výpůjčky. Nelze smazat.';

            if (!isset($_GET['ajax']))
                Yii::app()->user->setFlash('error', $text);
            else
                echo "<div class='flash-error'>" . $text . "</div>"; //for ajax}
        }
        
        if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Employee');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Employee('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['Employee'])) {
            $model->attributes = $_GET['Employee'];
        }
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = Employee::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'employee-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function saveModels($models, $create = true)
    {   // array($user, $employee, $address)
        $user = $models[0];
        $employee = $models[1];
        $address = $models[2];
        $valid = 0;

        if (isset($_POST['Usr'])) {
            $user->attributes = $_POST['Usr'];
            if ($create)
                $user->password = md5($user->password);
            // validate user input and redirect to the previous page if valid
            $valid = $user->validate() == 1;
        }

        if (isset($_POST['Employee'])) {
            $employee->attributes = $_POST['Employee'];
            $employee->employee_id = $user->usr_id;
            // validate user input and redirect to the previous page if valid
            $valid = $employee->validate() == 1 && $valid;
        }
        if (isset($_POST['Address']) && $_POST['Address'] != array()) {

            foreach ($_POST['Address'] as $key => $value) {
                if ($value == '')
                    unset($_POST['Address'][$key]);
            }

            $address->attributes = $_POST['Address'];
            // validate user input and redirect to the previous page if valid
            if ($address->validate() && $valid) {
                try {
                    $user->save();
                }
                catch (CDbException $e) {
                    Yii::app()->user->setFlash('error', "Tento login je již používán");
                    $this->redirect(array('/site/register'));
                }

                if (isset($_POST['Address']) && $_POST['Address'] != array()) {
                    if (!$address->save())
                        throw new CDbException();
                    $employee->address_id = $address->getPrimaryKey();
                }

                $employee->setPrimaryKey($user->getPrimaryKey());
                if (!$employee->save())
                    throw new CDbException();

                $this->redirect(array('view', 'id' => $employee->employee_id));
            }
        }
    }

}
