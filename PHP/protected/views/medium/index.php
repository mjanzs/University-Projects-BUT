<?php
/* @var $this MediumController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Media',
);

$this->menu = array(
    array('label' => 'Spravovat medie', 'url' => array('admin')),
    array('label' => 'Vytvořit medium', 'url' => array('create')),
    array('label' => 'Administrace', 'url' => array('/admin/index')),
);
?>

<h1>Media</h1>

<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
));
?>
