<?php

/**
 * This is the model class for table "tbl_medium".
 *
 * The followings are the available columns in table 'tbl_medium':
 * @property integer $medium_id
 * @property string $type
 * @property integer $price
 * @property integer $title_id
 * @property integer $borrowing_id
 *
 * The followings are the available model relations:
 * @property Borrowing $borrowing
 * @property MovTitle $title
 */
class Medium extends CActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Medium the static model class
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
        return 'tbl_medium';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title_id, price', 'required'),
            array('price, title_id, borrowing_id', 'numerical', 'integerOnly' => true),
            array('type', 'length', 'max' => 7),
            // advanced
            array('price', 'priceValidate'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('medium_id, type, price, title_id, borrowing_id', 'safe', 'on' => 'search'),
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
            'borrowing' => array(self::BELONGS_TO, 'Borrowing', 'borrowing_id'),
            'title' => array(self::BELONGS_TO, 'Title', 'title_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'medium_id' => 'Medium',
            'type' => 'Typ',
            'price' => 'Cena (Kč)',
            'title_id' => 'Titul',
            'borrowing_id' => 'Výpujčka',
        );
    }

    public function priceValidate($attribute, $params)
    {
        if ($this->price < 0 || $this->price > 1000)
            $this->addError($attribute, 'Cena musi být v intervalu 0 až 1000!');
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

        $criteria->with[] = 'title';
        $criteria->addSearchCondition("title.name", $this->title_id, true);

//        $criteria->with[] = 'borrowing';
//        $criteria->addSearchCondition("borrowing.customer_id", $this->title_id);
//        $criteria->addSearchCondition("borrowing.customer_id", $this->title_id);

        $criteria->compare('medium_id', $this->medium_id);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('price', $this->price);
//        $criteria->compare('title_id', $this->title_id);
//        $criteria->compare('borrowing_id', $this->borrowing_id);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => Yii::app()->params['gridPagination'],
                    ),
                ));
    }

}