<?php

/**
 * This is the model class for table "usr_address".
 *
 * The followings are the available columns in table 'usr_address':
 * @property integer $address_id
 * @property string $street
 * @property integer $street_number
 * @property string $town
 * @property integer $zip
 *
 * The followings are the available model relations:
 * @property Customer[] $customers
 * @property Employee[] $employees
 */
class Address extends CActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Address the static model class
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
        return 'usr_address';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('', 'required'),
            array('street_number, zip', 'numerical', 'integerOnly' => true),
            array('street, town', 'length', 'max' => 64),
            // advanced
            array('street_number, zip', 'numPositive'),
            array('zip', 'zipValid'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('address_id, street, street_number, town, zip', 'safe', 'on' => 'search'),
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
            'customers' => array(self::HAS_MANY, 'Customer', 'address_id'),
            'employees' => array(self::HAS_MANY, 'Employee', 'address_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'address_id' => 'Adresa',
            'street' => 'Ulice',
            'street_number' => 'Číslo popisné',
            'town' => 'Město',
            'zip' => 'PSČ',
        );
    }

    public function numPositive($attribute, $params)
    {
        if ($this->$attribute != '')
            if ($this->$attribute <= 0)
                $this->addError($attribute, $this->getAttributeLabel($attribute) . ' - atribut musí být kladný.');
    }

    public function zipValid($attribute, $params)
    {
        $pattern = '/^\d{5}$/';
        if ($this->$attribute != '')
            if (!preg_match($pattern, $this->$attribute))
                $this->addError($attribute, $this->getAttributeLabel($attribute) . ' - musí být 5 místné.');
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

        $criteria->compare('address_id', $this->address_id);
        $criteria->compare('street', $this->street, true);
        $criteria->compare('street_number', $this->street_number);
        $criteria->compare('town', $this->town, true);
        $criteria->compare('zip', $this->zip);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

}