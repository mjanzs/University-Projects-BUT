<?php
/* @var $this MediumController */
/* @var $model Medium */

$this->breadcrumbs = array(
    'Media' => array('index'),
    $model->medium_id => array('view', 'id' => $model->medium_id),
    'Upravit',
);

$this->menu = array(
    array('label' => 'Spravovat media', 'url' => array('admin')),
    array('label' => 'Seznam medii', 'url' => array('index')),
    array('label' => 'Vytvořit medium', 'url' => array('create')),
    array('label' => 'Náhled', 'url' => array('view', 'id' => $model->medium_id)),
    array('label' => 'Administrace', 'url' => array('/admin/index')),
);
?>

<h1>Upravit medium <?php echo $model->medium_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>