<?php
/* @var $this TitleController */
/* @var $model Title */
/* @var $genres Genre */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'title-form',
        'enableAjaxValidation' => true,
            ));
    ?>

    <p class="note">Pole s <span class="required">*</span> jsou povinná.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 128)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'director'); ?>
        <?php echo $form->textField($model, 'director', array('size' => 60, 'maxlength' => 128)); ?>
        <?php echo $form->error($model, 'director'); ?>
    </div>

<!--    <div class="row">
        < ?php echo $form->labelEx($model, 'count'); ?>
        < ?php echo $form->textField($model, 'count'); ?>
        < ?php echo $form->error($model, 'count'); ?>
    </div>-->

    <div class="row">
        <?php echo $form->labelEx($model, 'year'); ?>
        <?php echo $form->textField($model, 'year', array('size' => 4, 'maxlength' => 4)); ?>
        <?php echo $form->error($model, 'year'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'new'); ?>
        <?php echo $form->checkBox($model, 'new'); ?>
        <?php echo $form->error($model, 'new'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'picture'); ?>
        <?php echo $form->textField($model, 'picture', array('size' => 60, 'maxlength' => 64)); ?>
        <?php echo $form->error($model, 'picture'); ?>
    </div>
    <!--<div class="row">-->
    <?php //echo $form->dropDownList($genres, 'name', $listData, array('size' => 8, 'style' => 'width:200px', 'multiple' => 'multiple')); ?>
    <!--</div>-->

    <?php
    echo $form->labelEx(new Genre, 'name');

    $radio = $this->beginWidget('zii.widgets.jui.CJuiButton', array(
        'name' => 'btnradio',
        'buttonType' => 'buttonset',
        'htmlOptions' => array('style' => 'width: 200px'),
//        'onclick' => new CJavaScriptExpression('function(){alert("x");}'),
            ));
    foreach (Genre::model()->findAll() as $g) {
        $genre = Genre::model()->findByPk($g->genre_id);
       
        echo '<input type="checkbox" id="Genres[' . $genre->genre_id . ']" ' . 'name="Genres[' . $genre->genre_id . ']"'
        . (TitleGenre::model()->findByAttributes(array('title_id' => $model->title_id, 'genre_id' => $g->genre_id)) != null ?
                'checked="yes"' : '') . '/>';
        echo '<label for="Genres[' . $genre->genre_id . ']" ;>' . $genre->name . '</label>';
    }
    $this->endWidget();
    ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Vytvořit' : 'Uložit'); ?>
    </div>

    <?php
//    $this->widget('zii.widgets.jui.CJuiButton', array(
//        'name' => 'submit',
//        'caption' => 'Save',
//// you can easily change the look of the button by providing the correct class
//// ui-button-error, ui-button-primary, ui-button-success
//        'htmlOptions' => array('class' => 'ui-button-error'),
//    ));
    ?>

    <?php $this->endWidget(); ?>

</div><!-- form -->