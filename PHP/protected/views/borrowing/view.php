<?php
/* @var $this BorrowingController */
/* @var $model Borrowing */

Yii::app()->user->setReturnUrl(array('/borrowing/view', 'id' => $model->borrowing_id));

$this->breadcrumbs = array(
    'Výpůjčky' => array('index'),
    $model->borrowing_id,
);

if (Yii::app()->user->isAdmin()) {
    $this->menu = array(
        array('label' => 'Spravovat výpůjčky', 'url' => array('admin')),
        array('label' => 'Seznam výpůjček', 'url' => array('index')),
        array('label' => 'Vytvořit výpůjčku', 'url' => array('create')),
        array('label' => 'Upravit', 'url' => array('update', 'id' => $model->borrowing_id)),
        array('label' => 'Smazat', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->borrowing_id), 'confirm' => 'Opravdu chcete smazat tento záznam?')),
        array('label' => 'Administrace', 'url' => array('/admin')),
    );
}
else {
    $this->menu = array(
        array('label' => 'Výpůjčky', 'url' => array('/customer/borrowings')),
    );
}
?>

<h1>Náhled výpůjčka #<?php echo $model->borrowing_id; ?></h1>

<?php
foreach (Yii::app()->user->getFlashes() as $key => $message) {
    echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
}

$isAdmin = Yii::app()->user->isAdmin();
$employee_take = null;

if ($model->employee_id_take != null) {
    $employee_name = Usr::model()->findByPk($model->employee_id_take)->username;

    if ($isAdmin)
        $employee_take = CHtml::link($employee_name, array('/employee/view', 'id' => $model->employee_id_take));
    else
        $employee_take = $employee_name;
}
else {
    if ($isAdmin)
        $employee_take = (CHtml::link('Převzít', array('/borrowing/assume', 'id' => $model->borrowing_id)) . ' ' .
                CHtml::link('Udělit pokutu', array(
                    'update', 'id' => $model->borrowing_id), array(
                    'style' => 'float:right;font-weight:bolder'
                )));
    else
        $employee_take = null;
}

$medium = Medium::model()->findByAttributes(array('borrowing_id' => $model->borrowing_id));

$this->widget('zii.widgets.CDetailView', array(
    'cssFile' => Yii::app()->baseUrl . '/css/detailview/styles.css',
    'data' => $model,
    'attributes' => array(
        'borrowing_id',
        array(
            'name' => 'borrowed',
            'value' => date('d.m.Y', strtotime($model->borrowed)),
        ),
        array(
            'name' => 'returned',
            'value' => $model->returned == null ? null : date('d.m.Y', strtotime($model->returned)),
        ),
        array(
            'name' => 'penalty',
            'type' => 'html',
            'value' => Yii::app()->user->isAdmin() ? ($model->penalty . ' ' .
                    ($model->returned == null ? CHtml::link('Udělit', array(
                        'update', 'id' => $model->borrowing_id), array(
                        'style' => 'float:right;font-weight:bolder'
                    )) : '' )):
                    $model->penalty
        ),
        array(
            'name' => 'customer_id',
            'type' => 'html',
            'value' =>
            $isAdmin ?
            CHtml::link(
                    Usr::model()->findByPk($model->customer_id)->username, array(
                '/customer/view', 'id' => $model->customer_id
            )) : Usr::model()->findByPk($model->customer_id)->username,
        ),
        array(
            'name' => 'employee_id_lend',
            'type' => 'html',
            'value' => $isAdmin ?
                    CHtml::link(
                            Usr::model()->findByPk($model->employee_id_lend)->username, array(
                        '/employee/view', 'id' => $model->employee_id_lend
                    )) : Usr::model()->findByPk($model->employee_id_lend)->username,
        ),
        array(
            'name' => 'employee_id_take',
            'type' => 'html',
            'value' => $employee_take,
        ),
        array(
            'name' => 'borrowing_medium',
            'type' => 'html',
            'value' => @$medium->title->name . ' - ' . @$medium->type . ' - ' . @$medium->medium_id,
        ),
        array(
            'name' => 'bill_id',
            'type' => 'html',
            'value' => $model->bill == null ? null : CHtml::link($model->bill_id, array('/bill/view', 'id' => $model->bill_id)),
        ),
    ),
));
?>
 