<?php
/* @var $this GenreController */
/* @var $model Genre */

$this->breadcrumbs = array(
    'Žánry' => array('index'),
    'Spravovat',
);

$this->menu = array(
    array('label' => 'Seznam žánrů', 'url' => array('index')),
    array('label' => 'Vytvořit žánr', 'url' => array('create')),
    array('label' => 'Administrace', 'url' => array('/admin/index')),
);

//Yii::app()->clientScript->registerScript('search', "
//$('.search-button').click(function(){
//	$('.search-form').toggle();
//	return false;
//});
//$('.search-form form').submit(function(){
//	$.fn.yiiGridView.update('genre-grid', {
//		data: $(this).serialize()
//	});
//	return false;
//});
//");
?>

<h1>Spravovat žánry</h1>

<p>
    Můžete vložit porovnávací operatory (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    nebo <b>=</b>) na začátek vyhledávané hodnoty pro získání hledaného obsahu.
</p>

<?php // echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
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
    'id' => 'genre-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
//        'genre_id',
        'name',
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
