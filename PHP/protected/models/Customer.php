<?php

/**
 * This is the model class for table "usr_customer".
 *
 * The followings are the available columns in table 'usr_customer':
 * @property integer $customer_id
 * @property string $email
 * @property string $name
 * @property string $surname
 * @property integer $address_id
 *
 * The followings are the available model relations:
 * @property Usr $customer
 * @property Address $address
 */
class Customer extends CActiveRecord
{

    public $town;
    public $street;
    public $street_number;
    public $username;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Customer the static model class
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
        return 'usr_customer';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email, name, surname', 'required'),
            array('customer_id, address_id', 'numerical', 'integerOnly' => true),
            array('email', 'length', 'max' => 128),
            array('name, surname', 'length', 'max' => 64),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('customer_id, email, name, surname, address_id, town, street, street_number, username', 'safe', 'on' => 'search'),
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
            'user' => array(self::BELONGS_TO, 'Usr', 'customer_id'),
            'address' => array(self::BELONGS_TO, 'Address', 'address_id'),
            'borrowing' => array(self::HAS_MANY, 'Borrowing', 'customer_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'customer_id' => 'Zákazník ID',
            'email' => 'Email',
            'name' => 'Jméno',
            'surname' => 'Příjmení',
            'address_id' => 'Adresa',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('customer_id', $this->customer_id, false);

        $criteria->compare('email', $this->email, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('surname', $this->surname, true);

        $criteria->with[] = 'user';
        $criteria->addSearchCondition('user.username', $this->username);

        $criteria->with[] = 'address';
        $criteria->addSearchCondition("address.town", $this->town);
        $criteria->addSearchCondition("address.street", $this->street);
        $criteria->addSearchCondition("address.street_number", $this->street_number);

        $sort = new CSort();
        $sort->attributes = array(
            'defaultOrder' => 'customer_id',
            'town' => array(
                'asc' => 'address.town',
                'desc' => 'address.town desc',
            ),
            'street' => array(
                'asc' => 'address.street',
                'desc' => 'address.street desc',
            ),
            'street_number' => array(
                'asc' => 'address.street_number',
                'desc' => 'address.street_number desc',
            ),
            'username' => array(
                'asc' => 'user.username',
                'desc' => 'user.username desc',
            ),
            '*'
        );

        $sort->defaultOrder = 'user.username asc';
        
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'sort' => $sort,
                    'pagination' => array(
                        'pageSize' => Yii::app()->params['gridPagination'],
                    ),
                ));
    }

}