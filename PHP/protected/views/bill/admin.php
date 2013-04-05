<?php
/* @var $this BillController */
/* @var $model Bill */

$this->breadcrumbs = array(
    'Účtenky' => array('index'),
    'Spravovat',
);

$this->menu = array(
    array('label' => 'Zobrazit vše', 'url' => array('admin')),
    array('label' => 'Spravovat výpůjčky', 'url' => array('/borrowing/admin')),
    array('label' => 'Seznam účtenek', 'url' => array('index')),
    array('label' => 'Administrace', 'url' => array('/admin')),
//	array('label'=>'Create Bill', 'url'=>array('create')),
);

//Yii::app()->clientScript->registerScript('search', "
//$('.search-button').click(function(){
//	$('.search-form').toggle();
//	return false;
//});
//$('.search-form form').submit(function(){
//	$.fn.yiiGridView.update('bill-grid', {
//		data: $(this).serialize()
//	});
//	return false;
//});
//");
?>

<h1>Spravovat účtenky</h1>

<p>
    Můžete vložit porovnávací operatory (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    nebo <b>=</b>) na začátek vyhledávané hodnoty pro získání hledaného obsahu.
</p>


<?php // echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<!--<div class="search-form" style="display:none">
< ?php $this->renderPartial('_search',array(
        'model'=>$model,
)); ?>
</div> search-form -->
<?php echo CHtml::link('Nulovat vyhledávání', array('admin'), array('style' => 'font-size:120%;')) ?>
<?php
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerCoreScript('jquery.ui');

$date_defaultOptions = array(
    'showOn' => 'focus',
    'dateFormat' => 'yy-mm-dd',
    'showOtherMonths' => true,
    'selectOtherMonths' => true,
    'changeMonth' => true,
    'changeYear' => true,
    'showButtonPanel' => true,
);

$this->widget('zii.widgets.grid.CGridView', array(
    'cssFile' => Yii::app()->baseUrl . '/css/gridview/styles.css',
    'ajaxUpdate' => false,
    'id' => 'bill-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        array(
            'name' => 'bill_id',
            'htmlOptions' => array(
                'style' => 'width: 30px;'
            ),
            'header' => 'ID',
        ),
        array(
            'name' => 'time',
            'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'time',
                'language' => 'cs',
                'htmlOptions' => array(
                    'id' => 'datepicker_for_bill_time',
                ),
                'defaultOptions' => $date_defaultOptions,
                    ), true),
            'value' => 'date("d.m.Y H:m:s", strtotime($data->time))',
        ),
        array(
            'name' => 'title_id',
            'type' => 'html',
            'value' => '
                CHtml::link(Title::model()->findByPk($data->title_id)->name, array("/title/view", "id" => $data->title_id));
            ',
            'filter' => '',
        ),
        array(
            'name' => 'type',
            'filter' => array('Blu-ray'=>'Blu-ray', 'DVD' => 'DVD', 'VHS' => 'VHS')
        ),
        array (
            'name' => 'days',
            'value' => '$data->days',
            'htmlOptions' => array(
                'style' => 'width: 40px;'
            ),
        ),
        array (
            'name' => 'price',
            'value' => '$data->price',
            'htmlOptions' => array(
                'style' => 'width: 40px;'
            ),
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}'
        ),
    ),
    'pager' => array(
        'cssFile' => Yii::app()->baseUrl . '/css/pager.css',
        'header' => false,
    ),
));
?>
