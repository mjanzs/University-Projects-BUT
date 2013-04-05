<?php

class TitleController extends Controller
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
            'postOnly + deletethis', // we only allow deletion via POST request
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
                'actions' => array('index', 'view', 'list'),
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array('create', 'update', 'admin', 'delete', 'deleteThis'),
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
        $model = new Title;
        $genres = null;

        $this->performAjaxValidation($model);

        if (isset($_POST['Title'])) {
            $model->attributes = $_POST['Title'];
            if ($model->save()) {

                if (isset($_POST['Genres'])) {
                    $this->saveGenres($model->title_id, $_POST['Genres']);
                }
                $this->redirect(array('view', 'id' => $model->title_id));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'genres' => $genres
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
        $genres = null;

        $this->performAjaxValidation($model);

        if (isset($_POST['Genres'])) {
            $this->updateGenres($id, $_POST['Genres']);
        }

        if (isset($_POST['Title'])) {
            $model->attributes = $_POST['Title'];
            print_r($model);
//            if ($model->save())
//                $this->redirect(array('view', 'id' => $model->title_id));
        }

        $this->render('update', array(
            'model' => $model,
            'genres' => $genres,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDeletethis($id)
    {
        try {
            $model = $this->loadModel($id);
            TitleGenre::model()->deleteAllByAttributes(array('title_id' => $id));
            Medium::model()->deleteAllByAttributes(array('title_id' => $id));
            $model->delete();
        }
        catch (CDbException $e) {

            $text = 'Titul je na vypůjčeném mediu nebo na učtence. Nelze smazat.';

            if (!isset($_GET['ajax']))
                Yii::app()->user->setFlash('error', $text);
            else
                echo "<div class='flash-error'>" . $text . "</div>"; //for ajax}
        }
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        $this->render('delete', array(
            'model' => $model,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $model = new Title;
        $this->render('index', array(
            'dataProvider' => $model->getIndexDataProvider(),
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Title('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Title']))
            $model->attributes = $_GET['Title'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionList()
    {
        $this->actionAdmin();
    }

    public function saveGenres($titleId, $genres)
    {

        foreach ($genres as $genreId => $on) {
            $titleGenre = new TitleGenre;
            $titleGenre->title_id = $titleId;
            $titleGenre->genre_id = $genreId;
            $titleGenre->save();
        }
    }

    public function updateGenres($titleId, $genres)
    {
        TitleGenre::model()->deleteAllByAttributes(array('title_id' => $titleId));
        $this->saveGenres($titleId, $genres);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = Title::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'title-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
