<?php
/* @var $this BorrowingController */
/* @var $model Borrowing */

$this->breadcrumbs=array(
	'Výpůjčky'=>array('index'),
	'Vytvořit',
);

$this->menu=array(
	array('label'=>'Spravovat výpůjčky', 'url'=>array('admin')),
	array('label'=>'Seznam výpůjček', 'url'=>array('index')),
	array('label'=>'Administrace', 'url'=>array('/admin')),
);
?>

<h1>Vytvořit výpůjčku</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>