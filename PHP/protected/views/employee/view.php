<?php
/* @var $this EmployeeController */
/* @var $model Employee */

$this->breadcrumbs = array(
    'Zaměstnanec' => array('index'),
    ucfirst($model->surname),
);

$this->menu = array(
    array('label' => 'Spravovat zaměstnance', 'url' => array('admin')),
    array('label' => 'Seznam zaměstnanců', 'url' => array('index')),
    array('label' => 'Vytvořit zaměstnance', 'url' => array('create')),
    array('label' => 'Upravit', 'url' => array('update', 'id' => $model->employee_id)),
    array('label' => 'Smazat', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->employee_id), 'confirm' => 'Opravdu chcete smazat tento záznam?')),
    array('label' => 'Administrace', 'url' => array('/admin/index')),
);
?>

<h1>Zaměstnanec #<?php echo $model->employee_id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'cssFile' => Yii::app()->baseUrl . '/css/detailview/styles.css',
    'data' => $model,
    'attributes' => array(
        'employee_id',
        array(
            'name' => 'user.username',
            'value' => $model->user->username
        ),
        'email',
        'name',
        'surname',
        'telephone_number',
        array(
            'name' => 'superuser',
            'value' => $model->superuser ? 'Ano' : 'Ne'),
        array('name' => '', 'value' => ''),
        'address.street',
        'address.street_number',
        'address.town',
        'address.zip',
        array(
            'type' => 'html',
            'value' => CHtml::link('Editovat', array('update', 'id' => $model->employee_id))
        )
    ),
));
?>
