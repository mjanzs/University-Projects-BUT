<?php
/* @var $this GenreController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Žánry',
);

$this->menu = array(
    array('label' => 'Spravovat žánry', 'url' => array('admin')),
    array('label' => 'Vytvořit žánr', 'url' => array('create')),
    array('label' => 'Administrace', 'url' => array('/admin/index')),
);
?>

<h1>Genres</h1>

<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
));
?>
