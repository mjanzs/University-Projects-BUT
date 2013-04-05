<?php
/* @var $this AddressController */
/* @var $model Address */

$this->breadcrumbs = array(
    'Addresses' => array('index'),
    $model->address_id,
);

$this->menu = array(
    array('label' => 'List Address', 'url' => array('index')),
    array('label' => 'Create Address', 'url' => array('create')),
    array('label' => 'Update Address', 'url' => array('update', 'id' => $model->address_id)),
    array('label' => 'Delete Address', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->address_id), 'confirm' => 'Opravdu chcete smazat tento záznam?')),
    array('label' => 'Manage Address', 'url' => array('admin')),
);
?>

<h1>View Address #<?php echo $model->address_id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'cssFile' => Yii::app()->baseUrl . '/css/detailview/styles.css',
    'data' => $model,
    'attributes' => array(
        'address_id',
        'street',
        'street_number',
        'town',
        'zip',
    ),
));
?>
