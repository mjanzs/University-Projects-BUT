<?php
/* @var $this MediumController */
/* @var $model Medium */

$this->breadcrumbs = array(
    'Media' => array('index'),
    'Vytvořit',
);

$this->menu = array(
    array('label' => 'Spravovat media', 'url' => array('admin')),
    array('label' => 'Seznam medii', 'url' => array('index')),
    array('label' => 'Administrace', 'url' => array('/admin/index')),
);
?>

<h1>Vytvořit Medium</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>