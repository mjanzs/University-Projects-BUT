<?php
/* @var $this TitleController */
/* @var $model Title */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
            ));
    ?>

    <div class="row">
        <?php echo $form->label($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 128)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'director'); ?>
        <?php echo $form->textField($model, 'director', array('size' => 60, 'maxlength' => 128)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'count'); ?>
        <?php echo $form->textField($model, 'count'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'year'); ?>
        <?php echo $form->textField($model, 'year', array('size' => 4, 'maxlength' => 4)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'new'); ?>
        <div >
            <?php
            $this->beginWidget('zii.widgets.jui.CJuiButton', array(
                'buttonType' => 'buttonset',
                'name' => 'new',
            ));
            echo CHtml::radioButtonList('Title[new]', '', array(
                '' => 'Nezáleží', '1' => 'Ano', '0' => 'Ne'), array(
                'separator' => ' '
            ));
            $this->endWidget();
            ?>
        </div>
    </div>
    <hr style="opacity: 0"/>
    <div class="row">
        <?php echo CHtml::label('Volné', 'Title[free]') ?>
        <div >
            <?php
            $this->beginWidget('zii.widgets.jui.CJuiButton', array(
                'buttonType' => 'buttonset',
                'name' => 'free',
            ));
            echo CHtml::radioButtonList('Title[free]', '', array(
                '' => 'Nezáleží', '1' => 'Ano'), array(
                'separator' => ' '
            ));
            $this->endWidget();
            ?>
        </div>
    </div>
    <hr style="opacity: 0"/>
    <div class="row">
        <?php
        $mediums = Medium::model()->findAll();
        $list = CHtml::listData($mediums, 'type', 'type');

        echo CHtml::label('Typ', 'Title[type]');
        echo CHtml::dropDownList('Title[type]', ' ', $list, array('empty' => ' '));
        ?>
    </div>

    <div class="row">
        <?php
        $genres = Genre::model()->findAll();
        $list = CHtml::listData($genres, 'genre_id', 'name');

        echo CHtml::label('Žánr', 'Title[genre]');
        echo CHtml::dropDownList('Title[genre]', ' ', $list, array('empty' => ' '));
        ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Hledat'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->