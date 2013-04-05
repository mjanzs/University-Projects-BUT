<?php
/* @var $this CustomerController */
/* @var $model Customer */

$this->breadcrumbs = array(
    'Zákazníci' => array('index'),
    ucfirst($model->surname),
);

$this->menu = array(
    array('label' => 'Spravovat zákazníky', 'url' => array('admin')),
    array('label' => 'Seznam zákazníků', 'url' => array('index')),
    array('label' => 'Vytvoži zákazníka', 'url' => array('create')),
    array('label' => 'Upravit', 'url' => array('update', 'id' => $model->customer_id)),
    array('label' => 'Smazat', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->customer_id), 'confirm' => 'Opravdu chcete smazat tento záznam?')),
    array('label' => 'Administrace', 'url' => array('/admin/index')),
);
?>

<h1>Zákazník <?php echo $model->surname; ?> #<?php echo $model->customer_id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'cssFile' => Yii::app()->baseUrl . '/css/detailview/styles.css',
    'data' => $model,
    'attributes' => array(
        'customer_id',
        array(
            'name' => 'user.username',
            'value' => @$model->user->username
        ),
        'email',
        'name',
        'surname',
        array(
            'name' => 'address.street',
            'value' => @$model->address->street
        ),
        array(
            'name' => 'address.street_number',
            'value' => @$model->address->street_number
        ),
        array(
            'name' => 'address.town',
            'value' => @$model->address->town
        ),
        array(
            'name' => 'address.zip',
            'value' => @$model->address->zip
        ),
        array(
            'type' => 'html',
            'value' => CHtml::link('Editovat', array('update', 'id' => $model->customer_id)),
        )
    ),
));
?>
