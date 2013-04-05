<?php
/* @var $this GenreController */
/* @var $model Genre */

$this->breadcrumbs = array(
    'Žánry' => array('index'),
    'Vytvořit',
);

$this->menu = array(
    array('label' => 'Spravovat žánry', 'url' => array('admin')),
    array('label' => 'Seznam žánru', 'url' => array('index')),
    array('label' => 'Administrace', 'url' => array('/admin/index')),
);
?>

<h1>Vytvořit žánr</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>