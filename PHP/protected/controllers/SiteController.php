<?php

class SiteController extends Controller
{

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact()
    {
        $model = new ContactForm;
//        if (isset($_POST['ContactForm'])) {
//            $model->attributes = $_POST['ContactForm'];
//            if ($model->validate()) {
//                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
//                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
//                $headers = "From: $name <{$model->email}>\r\n" .
//                        "Reply-To: {$model->email}\r\n" .
//                        "MIME-Version: 1.0\r\n" .
//                        "Content-type: text/plain; charset=UTF-8";
//
//                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
//                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
//                $this->refresh();
//            }
//        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('login', array(
            'model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionRegister()
    {
        $customer = new Customer;
        $user = new Usr;
        $address = new Address;
        $valid = 0;
        // if it is ajax validation request
        $this->performAjaxValidation(array($customer, $user, $address));

        // collect user input data
        if (isset($_POST['Usr'])) {
            $user->attributes = $_POST['Usr'];
            // validate user input and redirect to the previous page if valid
            $valid = $user->validate() == 1;
        }

        if (isset($_POST['Customer'])) {
            $customer->attributes = $_POST['Customer'];
            $customer->customer_id = $user->usr_id;
            // validate user input and redirect to the previous page if valid
            $valid = $customer->validate() == 1 && $valid;
        }

        if (isset($_POST['Address'])) {

            foreach ($_POST['Address'] as $key => $value) {
                if ($value == '')
                    unset($_POST['Address'][$key]);
            }

            $address->attributes = $_POST['Address'];
            // validate user input and redirect to the previous page if valid
            if ($address->validate() && $valid) {
                // save records
                $pass = $user->password;
                $user->password = md5($user->password);
                try {
                    $user->save();
                }
                catch (CDbException $e) {
                    Yii::app()->user->setFlash('error', "Tento login je již používán");
                    $this->redirect(array('/site/register'));
                }

                if (!$address->save())
                    throw new CDbException();
                $customer->address_id = $address->getPrimaryKey();

                $customer->setPrimaryKey($user->getPrimaryKey());
                if (!$customer->save())
                    throw new CDbException();


                // login
                $login = new LoginForm;
                $login->login = $user->username;
                $login->password = $pass;
                if ($login->login())
                    $this->redirect(Yii::app()->user->returnUrl);
            }
        }

        // display the login form
        $this->render('register', array(
            'customer' => $customer,
            'user' => $user,
            'address' => $address
                )
        );
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        unset(Yii::app()->session['lastAction']);
        $this->redirect(Yii::app()->homeUrl);
    }

    private function setLoginCookie()
    {
        Yii::app()->request->cookies['login'] = new CHttpCookie('login', 'true', array(
                    'expire' => 1
                ));
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

}