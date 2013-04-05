<?php
/* @var $this BorrowingController */
/* @var $model Borrowing */

Yii::app()->user->setReturnUrl(array('/borrowing/admin'));

$this->breadcrumbs = array(
    'Výpůjčky' => array('index'),
    'Spravovat',
);

if (Yii::app()->user->isAdmin()) {
    $this->menu = array(
        array('label' => 'Seznam výpůjček', 'url' => array('index')),
        array('label' => 'Vytvořit výpůjčku', 'url' => array('create')),
        array('label' => 'Administrace', 'url' => array('/admin')),
    );
}
else {
    $this->menu = array(
        array('label' => 'Zobrazit vše', 'url' => array('/customer/borrowings'))
    );
}
//Yii::app()->clientScript->registerScript('search', "
//$('.search-button').click(function(){
//	$('.search-form').toggle();
//	return false;
//});
//$('.search-form form').submit(function(){
//	$.fn.yiiGridView.update('borrowing-grid', {
//		data: $(this).serialize()
//	});
//	return false;
//});
//");
?>

<h1>Výpůjčky</h1>

<p>
    Můžete vložit porovnávací operatory (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    nebo <b>=</b>) na začátek vyhledávané hodnoty pro získání hledaného obsahu.
</p>

<?php
foreach (Yii::app()->user->getFlashes() as $key => $message) {
    echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
}
?>

<?php
if (Yii::app()->user->isAdmin())
    echo CHtml::link('Nulovat vyhledávání', array('admin'), array('style' => 'font-size:120%;'));
?>
<?php
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerCoreScript('jquery.ui');

$date_defaultOptions = array(
    'showOn' => 'focus',
    'dateFormat' => 'yy-mm-dd',
    'showOtherMonths' => true,
    'selectOtherMonths' => true,
    'changeMonth' => true,
    'changeYear' => true,
    'showButtonPanel' => true,
);

$this->widget('zii.widgets.grid.CGridView', array(
    'cssFile' => Yii::app()->baseUrl . '/css/gridview/styles.css',
    'ajaxUpdate' => false,
    'id' => 'borrowing-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        /* Borrowing ID */
        array(
            'name' => 'borrowing_id',
            'value' => '$data->borrowing_id',
            'header' => 'ID Vyp.',
            'htmlOptions' => array(
                'style' => 'width:30px;',
            ),
        ),
        /* Borrowing date */
        array(
            'name' => 'borrowed',
            'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'borrowed',
                'language' => 'cs',
                'htmlOptions' => array(
                    'id' => 'datepicker_for_borrowed_date',
                    'size' => '15',
                ),
                'defaultOptions' => $date_defaultOptions,
                    ), true),
            'value' => 'date("d.m.Y", strtotime($data->borrowed))',
        ),
        /* Returned date */
        array(
            'name' => 'returned',
            'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'returned',
                'language' => 'cs',
                'htmlOptions' => array(
                    'id' => 'datepicker_for_returned_date',
                    'size' => '15',
                ),
                'defaultOptions' => $date_defaultOptions,
                    ), true),
            'type' => 'html',
            'value' => '
                Yii::app()->user->isAdmin() ? 
                // admin
                    ($data->returned == null
                        ? CHtml::link("Převzít", array("/borrowing/assume", "id" => $data->borrowing_id))
                        : date("d.m.Y", strtotime($data->returned)))
                    : ($data->returned == null
                        ? "<i>Nevráceno</i>"
                        : date("d.m.Y", strtotime($data->returned)))',
        ),
        /* Penalty */
        array(
            'name' => 'penalty',
            'value' => '$data->penalty',
            'htmlOptions' => array(
                'style' => 'width:40px;',
            ),
        ),
        /* Customer ID */
        array(
            'name' => 'customer_id',
            'value' => '$data->customer_id',
            'header' => 'ID Zak.',
            'htmlOptions' => array(
                'style' => 'width:30px;',
            ),
        ),
        /* Customer username */
        array(
            'name' => 'customer_name',
            'value' => '@Usr::model()->findByPk($data->customer_id)->username',
            'header' => 'Zákazník',
            'filter' => '',
        ),
        /* medium */
        array(
            'name' => 'borrowing_medium',
            'type' => 'html',
            'value' => 'CHtml::link(@$data->medium->medium_id, array("/medium/view", "id"=>@$data->medium->medium_id))',
            'filter' => '',
        ),
        /* Emplyees */
        array(
            'name' => 'employee_lend',
            'header' => 'Vypůjčil',
            'type' => 'html',
            'value' => '@$data->medium->medium_id',
            'value' => '@Usr::model()->findByPk($data->employee_id_lend)->username',
            'htmlOptions' => array(
                'style' => 'width:60px;',
            ),
            'filter' => '',
        ),
        array(
            'name' => 'employee_take',
            'header' => 'Převzal',
            'value' => '@Usr::model()->findByPk($data->employee_id_take)->username',
            'htmlOptions' => array(
                'style' => 'width:60px;',
            ),
            'filter' => '',
        ),
        array(
            'name' => 'bill_id',
            'type' => 'html',
            'value' => '$data->bill_id == null 
                ? "Zobrazit"
                : CHtml::link("Zobrazit", array("/bill/view", "id" => $data->bill_id))',
            'filter' => '',
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => Yii::app()->user->isAdmin() ? '{view}{update}{delete}' : '{view}',
            'buttons' => array (
                'view' => array (
                    'label' => 'Náhled',
                    'imageUrl' => Yii::app()->request->baseUrl . '/css/gridview/view.png',
                    'url' => 'Yii::app()->createUrl("/borrowing/view", array("id"=>$data->borrowing_id))',
                ),
            ),
        ),
    ),
    'pager' => array(
        'cssFile' => Yii::app()->baseUrl . '/css/pager.css',
        'header' => false,
    ),
));
?>

<p>
    <b>Učet nelze vystavit, dokud není výpůjčka převzata.</b>
</p>