<?php

class BorrowingController extends Controller
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
                'actions' => array('view'),
                'users' => array('@'),
                'expression' => 'Yii::app()->controller->isOwner()',
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('admin', 'create', 'update', 'assume', 'index', 'view'),
                'users' => Yii::app()->user->getAdmins(),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('delete'), 
                'users' => Yii::app()->user->getSuperAdmins(),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function isOwner() {
        $usr = Usr::model()->findByAttributes(array('username' => Yii::app()->user->id));
        $id = Yii::app()->request->getQuery('id');
        $borrowing = Borrowing::model()->findByPk($id);
        
        return  isset($borrowing->customer_id ) && $borrowing->customer_id == $usr->usr_id;
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
        $model = new Borrowing;

        $this->performAjaxValidation($model);

        if (isset($_POST['Borrowing'])) {

            /* Create borrowing */
            $model->attributes = $_POST['Borrowing'];

            $model->borrowed = date('Y-m-d', strtotime($model->borrowed));
            $model->employee_id_lend =
                    @Usr::model()->findByAttributes(array(
                        'username' => $model->employee_id_lend))->usr_id;
            $model->customer_id = Usr::model()->findByAttributes(array(
                        'username' => $model->customer_id,
                    ))->usr_id;
            $model->returned = null;

            if (isset($_POST['Medium']))
                $model->borrowing_medium = true;

            if ($model->save()) {

                /* Lend medium */

                $medium = Medium::model()->findByPk($_POST['Borrowing']['medium_id']);
                $medium->borrowing_id = $model->borrowing_id;

                if ($medium->save())
                    $this->redirect(array('view', 'id' => $model->borrowing_id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Borrowing'])) {
            $model->attributes = $_POST['Borrowing'];
            $model->borrowed = date('Y-m-d', strtotime($model->borrowed));
            $model->medium_id = true;
            $model->borrowing_medium = true;
            $model->customer_id = @Usr::model()->findByAttributes(array(
                        'username' => $model->customer_id,
                    ))->usr_id;
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->borrowing_id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionAssume($id)
    {

        $model = $this->loadModel($id);

        $model->returned = date('Y-m-d');
        $model->employee_id_take = Usr::model()->findByAttributes(array(
                    'username' => Yii::app()->user->id))->usr_id;
        $model->borrowing_medium = true;

        Yii::app()->user->setFlash('notice', "Výpůjčka č." . $id . '<br/>' .
                'Převzal: ' . Yii::app()->user->id . '<br/>' .
                'Dne: ' . date('d.m.Y'));

        /* create bill */

        $bill = Bill::create($model);

        $success = '';

        /* free medium */
        $medium = Medium::model()->findByAttributes(array('borrowing_id' => $model->borrowing_id));

        if ($bill->save()) {
            $success .= "Učetenka vytvořena";
            $medium->borrowing_id = null;
            $medium->save();
        }
        else {
            Yii::app()->user->setFlash('error', "Uložení selhalo!");
            $this->redirect(array('admin'));
        }

        $model->bill_id = $bill->getPrimaryKey();
        $model->medium_id = true;

        if ($model->save()) {
            $success .= "<br/>Data uložena";
            Yii::app()->user->setFlash('success', $success);
        }
        else {
            throw new Exception(print_r($model->getErrors(), true));
            Yii::app()->user->setFlash('error', "Uložení selhalo!");
        }

        $this->redirect(Yii::app()->user->returnUrl);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Medium::model()->findByAttributes(array('borrowing_id' => $id)) != null) {
            Yii::app()->user->setFlash('error', "Medium z výpůjčky nebylo vráceno!");
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        $model = $this->loadModel($id);
        $bill_id = $model->bill_id;
        $model->delete();
        Bill::model()->deleteByPk($bill_id);

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Borrowing');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Borrowing('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Borrowing']))
            $model->attributes = $_GET['Borrowing'];

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
        $model = Borrowing::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'borrowing-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
