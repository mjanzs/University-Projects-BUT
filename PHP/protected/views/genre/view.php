<?php
/* @var $this GenreController */
/* @var $model Genre */

$this->breadcrumbs = array(
    'Žánry' => array('index'),
    $model->name,
);

$this->menu = array(
    array('label' => 'Spravovat žánry', 'url' => array('admin')),
    array('label' => 'Seznam žánrů', 'url' => array('index')),
    array('label' => 'Vytvořit žánr', 'url' => array('create')),
    array('label' => 'Upravit', 'url' => array('update', 'id' => $model->genre_id)),
    array('label' => 'Smazat', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->genre_id), 'confirm' => 'Opravdu chcete smazat tento záznam?')),
    array('label' => 'Administrace', 'url' => array('/admin/index')),
);
?>

<h1>Náhled žánru #<?php echo $model->genre_id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'cssFile' => Yii::app()->baseUrl . '/css/detailview/styles.css',
    'data' => $model,
    'attributes' => array(
        'genre_id',
        'name',
    ),
));
?>
