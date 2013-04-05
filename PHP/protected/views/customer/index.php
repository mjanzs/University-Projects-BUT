<?php
/* @var $this CustomerController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Zákazníci',
);

$this->menu = array(
    array('label' => 'Spravovat zákazníky', 'url' => array('admin')),
    array('label' => 'Vytvořit zákazníka', 'url' => array('create')),
    array('label' => 'Administrace', 'url' => array('/admin/index')),
);
?>

<h1>Zákazníci</h1>

<?php
$this->widget('zii.widgets.CListView', array(
    'enableSorting' => true,
    'sortableAttributes' => array(
        'customer_id',
        'name',
        'surname',
    ),
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
    'template' => '{sorter} {pager}{items}{pager}{summary}'
));
?>
