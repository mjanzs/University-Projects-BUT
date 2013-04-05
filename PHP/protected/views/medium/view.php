<?php
/* @var $this MediumController */
/* @var $model Medium */

$this->breadcrumbs = array(
    'Media' => array('index'),
    $model->medium_id,
);

if (Yii::app()->user->isAdmin()) {
    $this->menu = array(
        array('label' => 'Spravovat media', 'url' => array('admin')),
        array('label' => 'Seznam medii', 'url' => array('index')),
        array('label' => 'Vytvořit medium', 'url' => array('create')),
        array('label' => 'Upravit', 'url' => array('update', 'id' => $model->medium_id)),
        array('label' => 'Smazat', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->medium_id), 'confirm' => 'Opravdu chcete smazat tento záznam?')),
        array('label' => 'Administrace', 'url' => array('/admin/index')),
    );
}
else {
  $this->menu = array(
        array('label' => 'Výpůjčky', 'url' => array('/customer/borrowings')),
    );  
}
?>

<h1>Náhled medium #<?php echo $model->medium_id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'cssFile' => Yii::app()->baseUrl . '/css/detailview/styles.css',
    'data' => $model,
    'attributes' => array(
        'medium_id',
        array(
            'name' => 'Titul',
            'type' => 'html',
            'value' => CHtml::link($model->title->name, array('/title/view', 'id' => $model->title->title_id)),
        ),
        'type',
        'price',
//        'title_id',
        array(
            'name' => 'borrowing_id',
            'type' => 'html',
            'value' => CHtml::link($model->borrowing_id, array('/borrowing/view', 'id' => $model->borrowing_id))
        ),
        array(
            'type' => 'html',
            'value' => Yii::app()->user->isAdmin() ?
                    CHtml::link('Editovat', array('update', 'id' => $model->medium_id)) : '',
        )
    ),
));
?>
