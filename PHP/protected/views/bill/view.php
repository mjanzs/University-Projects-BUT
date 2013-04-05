<?php
/* @var $this BillController */
/* @var $model Bill */

$this->breadcrumbs = array(
    'Účtenky' => array('index'),
    $model->bill_id,
);
if (Yii::app()->user->isAdmin()) {
    $this->menu = array(
        array('label' => 'Spravovat výpůjčky', 'url' => array('/borrowing/admin')),
        array('label' => 'Spravovat účtenky', 'url' => array('admin')),
        array('label' => 'Seznam účtenek', 'url' => array('index')),
        array('label' => 'Administrace', 'url' => array('/admin')),
//    array('label' => 'Upravit', 'url' => array('update', 'id' => $model->bill_id)),
    );
}
else {
    $this->menu = array(
        array('label' => 'Výpůjčky', 'url' => array('/customer/borrowings')),
    );
}
//if (Yii::app()->user->isSuperAdmin())
//$this->menu[] = array('label' => 'Smazat', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->bill_id), 'confirm' => 'Opravdu chcete smazat tento záznam?'));
?>
<div id="bill">
    <h1>Účtenka #<?php echo $model->bill_id; ?></h1>

    <?php
    
    $borrowing = Borrowing::model()->findByAttributes(array(
        'bill_id' => $model->bill_id
    ));
    
    $title = Title::model()->findByPk($model->title_id);

    $this->widget('zii.widgets.CDetailView', array(
        'cssFile' => Yii::app()->baseUrl . '/css/detailview/styles.css',
        'data' => $model,
        'attributes' => array(
            'bill_id',
            array(
                'name' => 'time',
                'value' => date('d.m.Y H:m:s', strtotime($model->time)),
            ),
            array(
                'name' => 'title_id',
                'type' => 'html',
                'value' => CHtml::link($title->name, array('/title/view', 'id' => $title->title_id)),
            ),
            'type',
            'price',
            'days',
            array(
                'name' => 'výpůjčka',
                'type' => 'html',
                'value' => @CHtml::link($borrowing->borrowing_id, array('/borrowing/view', 'id' => $borrowing->borrowing_id))
            )
        ),
    ));
    ?>
</div>

<?php if (Yii::app()->user->isAdmin()) : ?>

    <?php
    Yii::app()->clientScript->registerScript('print', "
    $('#printBill').click(function () {
        var w = window.open();
        var html = $(\"#bill\").html();
        w.document.writeln(html);
        w.print();
    });
");
    ?>

    <a href="javascript:void(0)" id="printBill" 
       style="font-size:200%;font-weight:bolder;float:right;margin-bottom: 25px;">Tisk</a>

<?php endif; ?>