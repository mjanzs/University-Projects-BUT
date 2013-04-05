<?php
/* @var $this MediumController */
/* @var $model Medium */

$this->breadcrumbs = array(
    'Media' => array('index'),
    'Spravovat',
);

$this->menu = array(
    array('label' => 'Seznam Medii', 'url' => array('index')),
    array('label' => 'Vytvořit Medium', 'url' => array('create')),
    array('label' => 'Administrace', 'url' => array('/admin/index')),
);

//Yii::app()->clientScript->registerScript('search', "
//$('.search-button').click(function(){
//	$('.search-form').toggle();
//	return false;
//});
//$('.search-form form').submit(function(){
//	$.fn.yiiGridView.update('medium-grid', {
//		data: $(this).serialize()
//	});
//	return false;
//});
//");
?>

<h1>Spravovat Media</h1>

<p>
    Můžete vložit porovnávací operatory (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    nebo <b>=</b>) na začátek vyhledávané hodnoty pro získání hledaného obsahu.
</p>

<?php // echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<!--<div class="search-form" style="display:none">
<?php
//$this->renderPartial('_search',array(
//	'model'=>$model,
//)); 
?>
</div> search-form -->
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'cssFile' => Yii::app()->baseUrl . '/css/gridview/styles.css',
    'ajaxUpdate' => false,
    'id' => 'medium-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        array(
            'name' => 'medium_id',
            'value' => '$data->medium_id',
            'htmlOptions' => array(
                'style' => 'width: 25px;'
            ),
        ),
        array(
            'name' => 'title_id',
            'header' => 'Titul',
            'type' => 'html',
            'value' => 'CHtml::link($data->title->name, array("/title/view", "id" => $data->title->title_id))',
        ),
        array(
            'name' => 'type',
            'filter' => array('DVD' => 'DVD', 'Blu-ray' => 'Blu-ray', 'VHS' => 'VHS'),
        ),
        array(
            'name' => 'price',
            'value' => '$data->price',
            'htmlOptions' => array(
                'style' => 'width: 40px;'
            ),
        ),
        array(
            'name' => 'borrowing_id',
            'type' => 'html',
            'value' => 'CHtml::link($data->borrowing_id, array("/borrowing/view", "id"=>$data->borrowing_id))',
            'htmlOptions' => array(
                'style' => 'width: 30px;'
            ),
        ),
        array(
            'class' => 'CButtonColumn',
        ),
    ),
    'pager' => array(
        'cssFile' => Yii::app()->baseUrl . '/css/pager.css',
        'header' => false,
    ),
));
?>
