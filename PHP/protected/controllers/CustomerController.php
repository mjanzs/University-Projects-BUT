<?php

class CustomerController extends Controller
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
                'actions' => array('borrowings'),
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete'),
                'users' => Yii::app()->user->getAdmins(),
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
        $customer = new Customer;
        $address = new Address;
        $models = array($customer, $user, $address);

        // if it is ajax validation request
        $this->performAjaxValidation($models);

        $this->saveModels($models);

        $this->render('create', array(
            'customer' => $customer,
            'user' => $user,
            'address' => $address,
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
        unset($user->password);

        $customer = $this->loadModel($id);

        $address = $customer->address_id == null ? new Address : Address::model()->findByPk($customer->address_id);
        $models = array($customer, $user, $address);

        // if it is ajax validation request
        $this->performAjaxValidation($models);

        $this->saveModels($models);

        $this->render('update', array(
            'customer' => $customer,
            'user' => $user,
            'address' => $address,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $model = $this->loadModel($id);

        try {
            Borrowing::model()->deleteAllByAttributes(array('customer_id' => $id));
            $model->delete();
            $model->user->delete();
        }
        catch (CDbException $e) {

            $text = 'Na zákazníka ' . $model->user->username . ' jsou vedeny výpůjčky. Nelze smazat.';

            if (!isset($_GET['ajax']))
                Yii::app()->user->setFlash('error', $text);
            else
                echo "<div class='flash-error'>" . $text . "</div>"; //for ajax}
        }



        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Customer');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionBorrowings()
    {
        
        $model = new Borrowing('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['Borrowing'])) {
            $model->attributes = $_GET['Borrowing'];    
        }
        
        $id = Usr::model()->findByAttributes(array('username' => Yii::app()->user->id))->usr_id;
        $model->setAttribute('customer_id', $id);
        
        $this->render('/borrowing/admin', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Customer('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Customer']))
            $model->attributes = $_GET['Customer'];

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
        $model = Customer::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'customer-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    private function saveModels($models, $create = true)
    {   //array($customer, $user, $address);
        $customer = $models[0];
        $user = $models[1];
        $address = $models[2];
        $valid = 0;

        // collect user input data
        if (isset($_POST['Usr'])) {
            $user->attributes = $_POST['Usr'];
            if ($create)
                $user->password = md5($user->password);
            // validate user input and redirect to the previous page if valid
            $valid = $user->validate() == 1;
        }

        if (isset($_POST['Customer'])) {
            $customer->attributes = $_POST['Customer'];
            $customer->customer_id = $user->usr_id;
            // validate user input and redirect to the previous page if valid
            $valid = $customer->validate() == 1 && $valid;
        }

        if (isset($_POST['Address']) && $_POST['Address'] != array()) {

            foreach ($_POST['Address'] as $key => $value) {
                if ($value == '')
                    unset($_POST['Address'][$key]);
            }

            $address->attributes = $_POST['Address'];
            // validate user input and redirect to the previous page if valid
            if ($address->validate() && $valid) {
                // save records               
                try {
                    $user->save();
                }
                catch (CDbException $e) {
                    Yii::app()->user->setFlash('error', "Tento login je již používán");
                    $this->redirect(array('/customer/create'));
                }

                if (!$address->save())
                    throw new CDbException();
                $customer->address_id = $address->getPrimaryKey();


                $customer->setPrimaryKey($user->getPrimaryKey());
                if (!$customer->save())
                    throw new CDbException();

                $this->redirect(array('view', 'id' => $customer->customer_id));
            }
        }
    }

}
