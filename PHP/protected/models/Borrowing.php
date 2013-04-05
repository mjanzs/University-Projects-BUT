<?php

/**
 * This is the model class for table "tbl_borrowing".
 *
 * The followings are the available columns in table 'tbl_borrowing':
 * @property integer $borrowing_id
 * @property string $borrowed
 * @property string $returned
 * @property integer $penalty
 * @property integer $customer_id
 * @property integer $employee_id_lend
 * @property integer $employee_id_take
 * @property integer $bill_id
 *
 * The followings are the available model relations:
 * @property UsrCustomer $customer
 * @property UsrEmployee $employeeIdTake
 * @property UsrEmployee $employeeIdLend
 * @property Bill $bill
 * @property Medium[] $media
 */
class Borrowing extends CActiveRecord
{

    public $customer_name;
    public $borrowing_medium;
    public $employee_lend;
    public $employee_take;
    public $medium_id;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Borrowing the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tbl_borrowing';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('borrowed, customer_id, employee_id_lend, borrowing_medium, medium_id', 'required'),
            array('penalty, bill_id', 'numerical', 'integerOnly' => true),
            array('penalty', 'numerical', 'integerOnly' => true, 'min' => 0),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('borrowing_id, borrowed, returned, penalty, customer_id,
                employee_id_lend, employee_id_take, 
                customer_name, employee_lend, employee_take', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
            'employeeIdTake' => array(self::BELONGS_TO, 'Employee', 'employee_id_take'),
            'employeeIdLend' => array(self::BELONGS_TO, 'Employee', 'employee_id_lend'),
            'bill' => array(self::BELONGS_TO, 'Bill', 'bill_id'),
            'medium' => array(self::HAS_ONE, 'Medium', 'borrowing_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'borrowing_id' => 'Výpujčka ID',
            'borrowed' => 'Vypůjčeno',
            'returned' => 'Vráceno',
            'penalty' => 'Pokuta',
            'customer_id' => 'Zákazník',
            'employee_id_lend' => 'Vypůjčil',
            'employee_id_take' => 'Převzal',
            'bill_id' => 'Účet',
            'borrowing_medium' => 'Vypůjčené medium',
            'medium_id' => 'Medium',
        );
    }

    public static function getCustomerUsernames()
    {
        $array = array();

        foreach (Customer::model()->findAll() as $value) {
            $array[] = Usr::model()->findByPk($value->customer_id)->username;
        }

        return $array;
    }

    public static function getMediumSelect()
    {
        $array = array();
        foreach (Medium::model()->findAllBySql('select * from tbl_medium where borrowing_id is null') as $model) {
            $array[] = array(
                'label' => $model->title->name . ' - ' . $model->type . ' - ' . $model->medium_id, // label for dropdown list
                'title' => $model->title->name,
                'type' => $model->type,
                'id' => $model->medium_id,
            );
        }
        return $array;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        /* prepare data */
        $borrowed = $this->borrowed == null ? null : date("Y-m-d", strtotime($this->borrowed));
        $returned = $this->returned == null ? null : date("Y-m-d", strtotime($this->returned));

        $customer_id = @Usr::model()->findByAttributes(array('username' => $this->customer_name))->usr_id;
        $employee_id_lend = @Usr::model()->findByAttributes(array('username' => $this->employee_lend))->usr_id;
        $employee_id_take = @Usr::model()->findByAttributes(array('username' => $this->employee_take))->usr_id;

        // disable searching if not exists
        if ($this->customer_name != null && $customer_id == null)
            $customer_id = ' ';

        if ($this->employee_lend != null && $employee_id_lend == null)
            $customer_id = ' ';

        if ($this->employee_take != null && $employee_id_take == null)
            $customer_id = ' ';

        /* criteria */
        $criteria = new CDbCriteria;

        $criteria->compare('borrowing_id', $this->borrowing_id);
        $criteria->compare('borrowed', $borrowed);
        $criteria->compare('returned', $returned);
        $criteria->compare('penalty', $this->penalty);
        $criteria->compare('customer_id', $this->customer_id);
        $criteria->compare('employee_id_lend', $this->employee_id_lend);
        $criteria->compare('employee_id_take', $this->employee_id_take);
//        $criteria->compare('bill_id', $this->bill_id);

//        $criteria->with[] = 'customer';
//        $criteria->compare('customer_id', $customer_id);

        $criteria->with[] = 'employeeIdLend';
        $criteria->compare('employeeIdLend.employee_id', $employee_id_lend);
        $criteria->with[] = 'employeeIdTake';
        $criteria->compare('employeeIdTake.employee_id', $employee_id_take);

//        $criteria->order = 'returned asc';

        $sort = new CSort();
        $sort->attributes = array(
            '*'
        );

        $sort->defaultOrder = 'returned';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'sort' => $sort,
                    'pagination' => array(
                        'pageSize' => Yii::app()->params['gridPagination'],
                    ),
                ));
    }

}