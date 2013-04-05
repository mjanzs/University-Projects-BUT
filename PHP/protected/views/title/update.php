<?php
/* @var $this TitleController */
/* @var $model Title */
/* @var $genres Genre */
$this->breadcrumbs = array(
    'Tituly' => array('index'),
    ucfirst($model->name) => array('view', 'id' => $model->title_id),
    'Upravit',
);

$this->menu = array(
    array('label' => 'Spravovat tituly', 'url' => array('admin')),
    array('label' => 'Seznam titulů', 'url' => array('index')),
    array('label' => 'Vytvořit titul', 'url' => array('create')),
    array('label' => 'Náhled', 'url' => array('view', 'id' => $model->title_id)),
    array('label' => 'Administrace', 'url' => array('/admin/index')),
);
?>

<h1>Upravit titul <?php echo $model->title_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model, 'genres' => $genres)); ?>