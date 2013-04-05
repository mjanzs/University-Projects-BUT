<?php
/* @var $this BorrowingController */
/* @var $model Borrowing */
/* @var $form CActiveForm */
?>

<?php
$date_defaultOptions = array(
    'showOn' => 'focus',
    'dateFormat' => 'yy-mm-dd',
    'showOtherMonths' => true,
    'selectOtherMonths' => true,
    'changeMonth' => true,
    'changeYear' => true,
    'showButtonPanel' => true,
);
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'borrowing-form',
        'enableAjaxValidation' => true,
            ));
    ?>

    <p class="note">Pole s <span class="required">*</span> jsou povinná.</p>

    <?php echo $form->errorSummary($model); ?>

    <?php if ($model->isNewRecord): ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'borrowed'); ?>
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name' => 'Borrowing[borrowed]',
                'language' => 'cs',
                'model' => $model,
                'defaultOptions' => $date_defaultOptions,
                'value' => date('d.m.Y'),
            ));
            ?>
            <?php echo $form->error($model, 'borrowed'); ?>
        </div>
    <?php else: ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'borrowed'); ?>
            <?php
            echo $form->textField($model, 'borrowed', array(
                'value' => $model->borrowed == 0 ? '' : date("d.m.Y", strtotime($model->borrowed)),
                'readonly' => '1'));
            ?>
            <?php echo $form->error($model, 'borrowed'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'returned'); ?>
            <?php
            echo $form->textField($model, 'returned', array(
                'value' => $model->returned == 0 ? '' : date("d.m.Y", strtotime($model->returned)),
                'readonly' => '1'));
            ?>
            <?php echo $form->error($model, 'returned'); ?>
        </div>
    <?php endif; ?>

    <?php if ($model->isNewRecord): ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'employee_id_lend'); ?>
            <?php
            echo $form->textField($model, 'employee_id_lend', array(
                'value' => Yii::app()->user->id,
                'readonly' => '1'));
            ?>
            <?php echo $form->error($model, 'employee_id_lend'); ?>
        </div>
    <?php else: ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'employee_id_take'); ?>
            <?php
            echo $form->textField($model, 'employee_id_take', array(
                'value' => Yii::app()->user->id,
                'readonly' => '1'));
            ?>
            <?php echo $form->error($model, 'employee_id_take'); ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'penalty'); ?>
        <?php
        if ($model->bill_id == null)
            $o = array();
        else
            $o = array('readonly' => '1');
        
        echo $form->textField($model, 'penalty', $o);
        ?>
        <?php echo $form->error($model, 'penalty'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'customer_id'); ?>
        <!--< ?php echo $form->textField($model, 'customer_id'); ?>-->
        <?php
        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
            'name' => 'Borrowing[customer_id]',
            'source' => Borrowing::getCustomerUsernames(),
            // additional javascript options for the autocomplete plugin
            'options' => array(
                'minLength' => '0',
            ),
            'value' => @Usr::model()->findByPk($model->customer_id)->username,
        ));
        ?>
        <?php echo "Napověda: po prvním znaku"; ?>
        <?php echo $form->error($model, 'customer_id'); ?>
    </div>

    <!--    <div class="row">
            < ?php echo $form->labelEx($model, 'bill_id'); ?>
            < ?php echo $form->textField($model, 'bill_id'); ?>
            < ?php echo $form->error($model, 'bill_id'); ?>
        </div>-->

    <?php if ($model->isNewRecord): ?>

        <?php echo $form->labelEx($model, 'borrowing_medium'); ?>
        <?php echo "Jméno titulu - typ media - id media" ?><br/>
        <?php
        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
            'attribute' => 'Borrowing[medium]',
            'id' => 'borrowing_medium',
            'name' => 'borrowing_medium',
            'source' => Borrowing::getMediumSelect(),
            'options' => array(
                'select' => "js:function(event, ui) {
                    $('#title').val(ui.item.title);
                    $('#type').val(ui.item.type);
                    $('#medium_id').val(ui.item.id);
                }"
            ),
            'htmlOptions' => array(
                'size' => '40'
            ),
        ));
        ?>
        <?php echo "Napověda: po prvním znaku"; ?><br/>
        <?php echo CHtml::textField('Medium[title]', '', array('id' => 'title', 'readonly' => '1')) ?>
        <?php echo CHtml::textField('Medium[type]', '', array('id' => 'type', 'readonly' => '1')) ?>
        <?php echo CHtml::textField('Borrowing[medium_id]', '', array('id' => 'medium_id', 'readonly' => '1')) ?>
        <?php echo $form->error($model, 'medium_id'); ?>

    <?php endif; ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Vytvořit' : 'Uložit'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->