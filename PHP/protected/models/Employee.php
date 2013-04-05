<?php

/**
 * This is the model class for table "usr_employee".
 *
 * The followings are the available columns in table 'usr_employee':
 * @property integer $employee_id
 * @property string $email
 * @property string $name
 * @property string $surname
 * @property integer $telephone_number
 * @property integer $superuser
 * @property integer $address_id
 *
 * The followings are the available model relations:
 * @property Usr $employee
 * @property Address $address
 */
class Employee extends CActiveRecord
{

    public $username;
    public $town;
    public $street;
    public $street_number;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Employee the static model class
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
        return 'usr_employee';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email, name, surname, telephone_number', 'required'),
            array('employee_id, telephone_number, superuser, address_id', 'numerical', 'integerOnly' => true),
            array('email', 'length', 'max' => 128),
            array('name, surname', 'length', 'max' => 64),
            // advanced
            array('telephone_number', 'telValidate'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('employee_id, email, name, surname, telephone_number, superuser,
                address_id, town, street, street_number, username', 'safe', 'on' => 'search'),
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
            'user' => array(self::BELONGS_TO, 'Usr', 'employee_id'),
            'address' => array(self::BELONGS_TO, 'Address', 'address_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'employee_id' => 'ID Zaměstnanece',
            'email' => 'Email',
            'name' => 'Jméno',
            'surname' => 'Příjmení',
            'telephone_number' => 'Telefoní číslo',
            'superuser' => 'Admin (Vyšší úrovně)',
            'address_id' => 'Adresa',
            'address' => 'Adresa',
            'username' => 'Přihlašovací jméno',
        );
    }

    public function telValidate($attribute, $params)
    {
        $pattern = '/^[0-9]{9}$/';

        if (!preg_match($pattern, $this->$attribute))
            $this->addError($attribute, 'Špatný formát telefoního čísla! (zadejte 9 místné bez předvolby)');
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($address = null)
    {

        $criteria = new CDbCriteria;

        $criteria->compare('employee_id', $this->employee_id);

        $criteria->compare('email', $this->email, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('surname', $this->surname, true);
        $criteria->compare('telephone_number', $this->telephone_number, true);
        $criteria->compare('superuser', $this->superuser);

        $criteria->with[] = 'user';
        $criteria->compare("user.username", $this->username, true);

        $criteria->with[] = 'address';
        $criteria->addSearchCondition("address.town", $this->town, true);
        $criteria->addSearchCondition("address.street", $this->street, true);
        $criteria->addSearchCondition("address.street_number", $this->street_number, true);

        $sort = new CSort();
        $sort->attributes = array(
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
        $sort->defaultOrder = 'employee_id';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'sort' => $sort,
                    'pagination' => array(
                        'pageSize' => Yii::app()->params['gridPagination'],
                    ),
                ));
    }

}