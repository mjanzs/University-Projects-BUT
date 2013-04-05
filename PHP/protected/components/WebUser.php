<?php

class WebUser extends CWebUser
{

    protected $_model;

    public function isAdmin()
    {
        $usr = $this->loadModel();
        return
                isset(Yii::app()->user->id) &&
                Employee::model()->findByPk($usr->usr_id) != array();
    }

    public function isSuperAdmin()
    {
        $usr = $this->loadModel();
        return
                isset(Yii::app()->user->id) &&
                Employee::model()->findByAttributes(array('employee_id' => $usr->usr_id, 'superuser' => 1)) != array();
    }

    public function getAdmins()
    {
        $employees = array();
        foreach (Usr::model()->findAll() as $usr) {
            if ($usr->employee)
                $employees[] = $usr->username;
        }
        if (is_array($employees))
            return $employees;
        else
            return array($employees);
    }

    public function getSuperAdmins()
    {
        $employees = array();
        foreach (Usr::model()->findAll() as $usr) {
            if ($usr->employee && $usr->employee->superuser == 1)
                $employees[] = $usr->username;
        }
        if (is_array($employees))
            return $employees;
        else
            return array($employees);
    }

    public static function validatePassword($user, $pass)
    {
        return $user->password === md5($pass);
    }

    private function loadModel()
    {
        return Usr::model()->findByAttributes(array('username' => $this->id));
    }

}