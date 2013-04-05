<?php
/* @var $this TitleController */
/* @var $data Title */
?>

<div class="view title-view">

    <div class="title-name">
        <!--<b><?php // echo CHtml::encode($data->getAttributeLabel('name'));  ?>:</b>-->
        <?php echo CHtml::link(CHtml::encode($data->name), array('view', 'id' => $data->title_id)); ?>
    </div>

    <div class="title-director">
        <b><?php echo CHtml::encode($data->getAttributeLabel('director')); ?>:</b>
        <?php echo CHtml::encode($data->director); ?>
    </div>

    <div class="title-count">
        <b><?php echo CHtml::encode($data->getAttributeLabel('count')); ?>:</b>
        <?php echo CHtml::encode($data->getMediumsCount($data->title_id)); ?>
    </div>

    <div class="title-count-available">
        <b><?php echo "K dispozici"; ?>:</b>
        <?php echo CHtml::encode($data->getMediumsCountAvailable($data->title_id)); ?>
    </div>

    <div class="title-year">
        <b><?php echo CHtml::encode($data->getAttributeLabel('year')); ?>:</b>
        <?php echo CHtml::encode($data->year); ?>
    </div>

    <div class="title-new">
        <b><?php echo CHtml::encode($data->getAttributeLabel('new')); ?>:</b>
        <?php
        echo ($data->new == 1) ? (CHtml::image(Yii::app()->baseUrl . "/images/icons/ok.png")) : (CHtml::image(Yii::app()->baseUrl . "/images/icons/cross.png"))
        ?>
    </div>

    <div class="title-picture">
        <?php echo CHtml::image($data->picture); ?>
    </div>

    <div class="title-genres">
        <?php echo $data->getGenresList() ?>
    </div>

    <div class="title-genres">
        <?php echo $data->getTypesList() ?>
    </div>
</div>