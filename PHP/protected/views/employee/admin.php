<?php
/* @var $this EmployeeController */
/* @var $model Employee */

$this->breadcrumbs = array(
    'Zaměstnanci' => array('index'),
    'Spravovat',
);

$this->menu = array(
    array('label' => 'Seznam zaměstnanců', 'url' => array('index')),
    array('label' => 'Vytvořit zaměstnance', 'url' => array('create')),
    array('label' => 'Administrace', 'url' => array('/admin/index')),
);

//Yii::app()->clientScript->registerScript('search', "
//$('.search-button').click(function(){
//	$('.search-form').toggle();
//	return false;
//});
//$('.search-form form').submit(function(){
//	$.fn.yiiGridView.update('employee-grid', {
//		data: $(this).serialize()
//	});
//	return false;
//});
//");
//
?>

<h1>Správa zaměstnanců</h1>

<p>
    Můžete vložit porovnávací operatory (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    nebo <b>=</b>) na začátek vyhledávané hodnoty pro získání hledaného obsahu.
</p>

<?php // echo CHtml::link('Advanced Search', '#', array('class' => 'search-button'));  ?>
<!--<div class="search-form" style="display:none">
<?php
//    $this->renderPartial('_search', array(
//        'model' => $model,
//    ));
?>
</div> search-form -->

<div id="statusMsg">
    <?php if (Yii::app()->user->hasFlash('success')): ?>
        <div class="flash-success">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php endif; ?>

    <?php if (Yii::app()->user->hasFlash('error')): ?>
        <div class="flash-error">
            <?php echo Yii::app()->user->getFlash('error'); ?>
        </div>
    <?php endif; ?>
</div>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'cssFile' => Yii::app()->baseUrl . '/css/gridview/styles.css',
    'ajaxUpdate' => false,
    'id' => 'employee-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        array(
            'name' => 'employee_id',
            'header' => 'ID',
            'value' => '$data->employee_id'
        ),
        array(
            'name' => 'username',
            'header' => 'Login',
            'value' => '$data->user->username'//'Usr::model()->findByPk($data->employee_id)->username'
        ),
        'name',
        'surname',
        'email',
        'telephone_number',
        array(
            'name' => 'superuser',
            'filter' => array('1' => 'Ano', '0' => 'Ne'),
            'type' => 'html',
            'value' => '($data->superuser=="1")
                ? (CHtml::image(Yii::app()->baseUrl."/images/icons/ok.png"))
                : (CHtml::image(Yii::app()->baseUrl."/images/icons/cross.png"))'
        ),
        //        ...
        //        ...
        array(
            'name' => 'town',
            'header' => 'Město',
            'value' => '@$data->address->town',
        ),
        array(
            'name' => 'street',
            'header' => 'Ulice',
            'value' => '@$data->address->street',
        ),
        array(
            'name' => 'street_number',
            'header' => 'ČP',
            'value' => '@$data->address->street_number',
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
