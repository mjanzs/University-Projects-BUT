<?php

/**
 * This is the model class for table "mov_title".
 *
 * The followings are the available columns in table 'mov_title':
 * @property integer $title_id
 * @property string $name
 * @property string $director
 * @property string $year
 * @property integer $new
 * @property string $picture
 *
 * The followings are the available model relations:
 * @property Genre[] $movGenres
 */
class Title extends CActiveRecord
{

    public $genres;
    public $genre;
    public $count;
    public $countAvaiable;
    public $type;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Title the static model class
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
        return 'mov_title';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, director, year, picture', 'required'),
            array('new, year', 'numerical', 'integerOnly' => true),
            array('name, director', 'length', 'max' => 128),
            array('year', 'length', 'max' => 4),
            array('picture', 'length', 'max' => 64),
            // advanced
            array('year', 'validateYear'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('title_id, name, director, year, new', 'safe', 'on' => 'search'),
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
            'movGenres' => array(self::MANY_MANY, 'Genre', 'mov_title_genre(title_id, genre_id)'),
            'titleGenre' => array(self::BELONGS_TO, 'TitleGenre', 'title_id'),
            'medium' => array(self::HAS_MANY, 'Medium', 'title_id'),
//            'mediumFree' => array(self::HAS_ONE, 'Medium', 'title_id'),
            'mediumCount' => array(self::STAT, 'Medium', 'title_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'title_id' => 'Titul',
            'name' => 'Jméno',
            'director' => 'Režisér',
            'year' => 'Rok',
            'new' => 'Novinka',
            'picture' => 'Obrázek',
            'movGenres' => 'Žánry',
            'count' => 'Počet',
            'type' => 'Typ',
        );
    }

    public function validateYear($attribute, $params)
    {
        if ($this->$attribute <= 0 || $this->$attribute > 3000)
            $this->addError($attribute, 'Špatně zadaný rok!');
    }

    public function getGenresList()
    {
        $list = '<ul class="title-genres">';
        foreach ($this->movGenres as $g) {
            $list .= '<li>' . $g->name . '</li>';
        }
        $list .= '</ul>';
        return $list;
    }

    public function getGenresText()
    {
        $text = '';
        foreach ($this->movGenres as $g)
            $text .= $g->name . '<br/>';
        return $text;
    }

    public function getGenres()
    {
        $array = array();
        foreach ($this->movGenres as $g)
            $array[$g->genre_id] = $g->name;
        return $array;
    }

    public static function getAllGenres()
    {
        $array = array();
        foreach (Genre::model()->findAll() as $g)
            $array[$g->genre_id] = $g->name;
        return $array;
    }

    public function getTypesList()
    {
        $list = '<ul class="title-genres">';
        foreach ($this->getMediumsTypes() as $g)
            $list .= '<li>' . $g->type . '</li>';

        $list .= '</ul>';
        return $list;
    }

    public function getTypesText()
    {
        $text = '';
        foreach ($this->getMediumsTypes() as $g)
            $text .= $g->type . '<br/>';
        return $text;
    }

    public function getTypes()
    {
        $array = array();
        foreach ($this->getMediumsTypes() as $g)
            $array[] = $g->type;
        return $array;
    }

    public function getMediumsTypes()
    {
        $criteria = new CDbCriteria();
        $criteria->compare('title_id', $this->title_id);
        $criteria->distinct = true;
        $criteria->select = 'type';

        return Medium::model()->findAll($criteria);
    }

    public function getMediumsCount($id)
    {
        return Medium::model()->countByAttributes(array('title_id' => $id));
    }

    public function getMediumsCountAvailable($id)
    {
        return Medium::model()->countByAttributes(array('title_id' => $id, 'borrowing_id' => null));
    }

    public static function getTitles()
    {
        $array = array();

        foreach (Title::model()->findAll(array('order' => 'name')) as $tit) {
            $array[$tit->title_id] = $tit->name;
        }

        return $array;
    }

    public function getIndexDataProvider()
    {

        $criteria = new CDbCriteria;

        if (isset($_GET['Title'])) {

            Yii::app()->user->setFlash('success', "Výsledek hledání: ");

            if ($_GET['Title']['name'] != '')
                $criteria->compare('name', $_GET['Title']['name'], true);

            if ($_GET['Title']['director'] != '')
                $criteria->compare('director', $_GET['Title']['director'], true);

            if ($_GET['Title']['year'] != '')
                $criteria->compare('year', $_GET['Title']['year']);

            if ($_GET['Title']['new'] != '')
                $criteria->compare('new', $_GET['Title']['new']);


            if (@$_GET['Title']['genre'] != '') {
                $criteria->with[] = 'titleGenre';
                $criteria->compare('titleGenre.genre_id', $_GET['Title']['genre']);
                $criteria->together = true;
            }

            if (@$_GET['Title']['type'] != '') {
                $criteria->with[] = 'medium';
                $criteria->compare('medium.type', $_GET['Title']['type']);
                $criteria->together = true;
            }

            if (@$_GET['Title']['free'] != '') {
                if ($_GET['Title']['free']) {
                    $criteria->with[] = 'medium';
                    $criteria->addCondition('medium.borrowing_id is null');
                    $criteria->addCondition('medium_id is not null');
                    $criteria->together = true;
                }
            }
        }
//        Yii::app()->user->setFlash('notice', $criteria->condition);
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => Yii::app()->params['moviesPagination'],
                    ),
                ));
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        return $this->getIndexDataProvider();

        /*
          $criteria = new CDbCriteria;

          $criteria->compare('title_id', $this->title_id);
          $criteria->compare('name', $this->name, true);
          $criteria->compare('director', $this->director, true);
          $criteria->compare('year', $this->year, true);
          $criteria->compare('new', $this->new);
          //        $criteria->compare('picture', $this->picture, true);
          //        $criteria->addInCondition('movaGenres.name', $this->getGenres());

          return new CActiveDataProvider($this, array(
          'criteria' => $criteria,
          'pagination' => array(
          'pageSize' => Yii::app()->params['gridPagination'],
          ),
          ));
         */
    }

}