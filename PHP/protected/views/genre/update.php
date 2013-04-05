<?php
/* @var $this GenreController */
/* @var $model Genre */

$this->breadcrumbs = array(
    'Žánry' => array('index'),
    ucfirst($model->name) => array('view', 'id' => $model->genre_id),
    'Upravit',
);

$this->menu = array(
    array('label' => 'Spravovat žánry', 'url' => array('admin')),
    array('label' => 'Seznam žánrů', 'url' => array('index')),
    array('label' => 'Vytvořit žánr', 'url' => array('create')),
    array('label' => 'Náhled', 'url' => array('view', 'id' => $model->genre_id)),
    array('label' => 'Administrace', 'url' => array('/admin/index')),
);
?>

<h1>Upravit žánr <?php echo $model->genre_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>