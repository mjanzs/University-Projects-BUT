<?php
/* @var $this TitleController */
/* @var $model Title */

$this->breadcrumbs = array(
    'Titul' => array('index'),
    ucfirst($model->name),
);
if (Yii::app()->user->isAdmin()) {
    $this->menu = array(
        array('label' => 'Spravovat tituly', 'url' => array('admin')),
        array('label' => 'Seznam titulů', 'url' => array('index')),
        array('label' => 'Vytvořit titul', 'url' => array('create')),
        array('label' => 'Upravit', 'url' => array('update', 'id' => $model->title_id)),
        array('label' => 'Smazat', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->title_id), 'confirm' => 'Opravdu chcete smazat tento záznam?')),
        array('label' => 'Administrace', 'url' => array('/admin/index')),
    );
}
else {
    $this->menu = array(
        array('label' => 'Výpůjčky', 'url' => array('/customer/borrowings')),
        array('label' => 'Seznam titulů', 'url' => array('index')),
    );
}
?>

<h1><?php echo $model->name; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'cssFile' => Yii::app()->baseUrl . '/css/detailview/styles.css',
    'data' => $model,
    'attributes' => array(
//        'title_id',
        'name',
        'director',
        array(
            'name' => 'count',
            'value' => $model->getMediumsCount($model->title_id),
        ),
        'year',
        array(
            'name' => 'new',
            'value' => $model->new ? "Ano" : "Ne",
        ),
        array(
            'name' => 'movGenres',
            'type' => 'html',
            'value' => $model->getGenresList(),
        ),
        array(
            'name' => 'type',
            'type' => 'html',
            'value' => $model->getTypesList(),
        ),
        array(
            'name' => 'picture',
            'type' => 'html',
            'value' => CHtml::image($model->picture),
        ),
    ),
));
?>
