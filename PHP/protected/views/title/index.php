<?php
/* @var $this TitleController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Filmy',
);

$this->menu = array(
//    array('label' => 'Zobrazit vše', 'url' => array('index')),
    array('label' => 'Vše', 'url' => array('index')),
    array('label' => 'Tabulka', 'url' => array('list')),
);
?>

<h1>Filmy</h1>

<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>

<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('title-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php echo CHtml::link('Vyhledávat', '#', array('class' => 'search-button')); ?>
<br/>
<hr style="opacity: 0">
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => Title::model(),
    ));
    ?>
</div> <!--search-form -->


<?php
$this->widget('zii.widgets.CListView', array(
    'ajaxUpdate' => false,
    'enableSorting' => true,
    'sortableAttributes' => array(
        'name',
        'director',
        'year',
        'new',
    ),
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
    'template' => '{sorter} {summary}{pager}{items}{pager}{summary}',
    'pager' => array(
        'cssFile' => Yii::app()->baseUrl . '/css/pager.css',
        'header' => false,
    ),
));
?>
