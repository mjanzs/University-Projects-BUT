<?php

/**
 * This is the model class for table "tbl_bill".
 *
 * The followings are the available columns in table 'tbl_bill':
 * @property integer $bill_id
 * @property string $time
 * @property integer $title_id
 * @property string $type
 * @property integer $days
 * @property integer $price
 *
 * The followings are the available model relations:
 * @property Borrowing[] $borrowings
 */
class Bill extends CActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Bill the static model class
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
        return 'tbl_bill';
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
            array('title_id, price, days', 'numerical', 'integerOnly' => true),
            array('type', 'length', 'max' => 7),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('bill_id, time, title_id, type, price', 'safe', 'on' => 'search'),
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
            'borrowings' => array(self::HAS_MANY, 'Borrowing', 'bill_id'),
            'title' => array(self::BELONGS_TO, 'Title', 'title_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'bill_id' => 'ID účtenky',
            'time' => 'Datum vystavení',
            'title_id' => 'Titul',
            'type' => 'Typ',
            'price' => 'Cena',
            'days' => 'Počet dni',
        );
    }

    /**
     * 
     * @param Borrowing $borrwing
     */
    public static function create($borrwing)
    {
        $bill = new Bill;

        $medium = Medium::model()->findByAttributes(array('borrowing_id' => $borrwing->borrowing_id));

        $bill->title_id = $medium->title->title_id;
        $bill->type = $medium->type;

        $ref = new DateTime($borrwing->borrowed);
        $now = new DateTime();
        $diff = $now->diff($ref);

        $days = ($diff->d == 0 ? 1 : $diff->d) + 30 * $diff->m + 365 * $diff->y;
        $bill->days = $days;
        $bill->price = $medium->price * $days + $borrwing->penalty;
//        throw new Exception("$medium->price * $days + $borrwing->penalty;");
        return $bill;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $date = $this->time == null ? null : date("Y-m-d", strtotime($this->time));

        $criteria = new CDbCriteria;

        $criteria->compare('bill_id', $this->bill_id);
        $criteria->compare('time', $date, true);
        $criteria->compare('title_id', $this->title_id);
        $criteria->compare('type', $this->type);
        $criteria->compare('days', $this->days);
        $criteria->compare('price', $this->price);

        $criteria->with[] = 'title';

        $sort = new CSort();
        $sort->attributes = array(
            'title_id' => array(
                'asc' => 'title.name',
                'desc' => 'title.name desc',
            ),
            '*'
        );

        $sort->defaultOrder = 'time desc';
        
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'sort' => $sort,
                    'pagination' => array(
                        'pageSize' => Yii::app()->params['gridPagination'],
                    ),
                ));
    }

}