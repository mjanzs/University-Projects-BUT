<?php
/* @var $this TitleController */
/* @var $model Title */
/* @var $genres Genre */

$this->breadcrumbs = array(
    'Titul' => array('index'),
    'Vytvořit',
);

$this->menu = array(
    array('label' => 'Spravovat titly', 'url' => array('admin')),
    array('label' => 'Seznam titulů', 'url' => array('index')),
    array('label' => 'Administrace', 'url' => array('/admin/index')),
);
?>

<h1>Vytvořit titul</h1>

<?php echo $this->renderPartial('_form', array('model' => $model, 'genres' => $genres)); ?>