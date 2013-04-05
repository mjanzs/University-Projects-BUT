<?php
/* @var $this TitleController */
/* @var $model Title */

$this->breadcrumbs = array(
    'Tituly' => array('index'),
    'Spravovat',
);

$this->menu = array(
    array('label' => 'Zobrazit vše', 'url' => array('list')),
    array('label' => 'Seznam titulů', 'url' => array('index')),
);

if (Yii::app()->user->isAdmin()) {
    $this->menu[] = array('label' => 'Vytvořit titul', 'url' => array('create'));
    $this->menu[] = array('label' => 'Administrace', 'url' => array('/admin/index'));
}
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('title-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Seznam titulů</h1>


<center>
    <p>
        <b>V tabulce je možné vyhledávat a řadit podle kriterii v hlavičce nebo<br/>
            pomocí pokročilého vyhledávání</b>
    </p>
    <p>
        Můžete vložit porovnávací operatory (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
        nebo <b>=</b>) na začátek vyhledávané hodnoty pro získání hledaného obsahu.
    </p>
</center>

<?php echo CHtml::link('Pokročilé vyhledávání', '#', array('class' => 'search-button', 'style' => 'font-size:100%')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div>
<hr style="opacity: 0"/>
<div id="statusMsg">
    <?php if (Yii::app()->user->hasFlash('success')): ?>
        <div class="flash-success">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
    <?php endif; ?>

    <?php if (Yii::app()->user->hasFlash('error')): ?>
        <div class="flash-error">
            <?php echo Yii::app()->user->getFlash('error'); ?>
        </div>
    <?php endif; ?>
</div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'cssFile' => Yii::app()->baseUrl . '/css/gridview/styles.css',
    'id' => 'title-grid',
    'ajaxUpdate' => false,
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
//        'title_id',
        'name',
        'director',
        array(
            'name' => 'year',
            'value' => '$data->year',
            'htmlOptions' => array(
                'style' => 'width:50px;'
            )
        ),
        array(
            'name' => 'new',
            'filter' => array('1' => 'Ano', '0' => 'Ne'),
            'type' => 'html',
            'value' => '($data->new=="1")?(CHtml::image(Yii::app()->baseUrl . "/images/icons/ok.png")):(CHtml::image(Yii::app()->baseUrl . "/images/icons/cross.png"))'
        ),
        array(
            'name' => 'genres',
            'type' => 'html',
            'value' => '$data->getGenresText()',
            'filter' => '',
            'header' => 'Žánry'
        ),
        array(
            'name' => 'type',
            'type' => 'html',
            'value' => '$data->getTypesText()',
            'filter' => '',
            'htmlOptions' => array(
                'style' => 'width:40px;'
            )
        ),
        array(
            'name' => 'count',
            'value' => '$data->getMediumsCount($data->title_id)',
            'filter' => '',
            'htmlOptions' => array(
                'style' => 'width:30px'
            )
        ),
        array(
            'name' => 'Volné',
            'value' => '$data->getMediumsCountAvailable($data->title_id)',
            'filter' => '',
            'htmlOptions' => array(
                'style' => 'width:30px'
            )
        ),
        /*
          'picture',
         */
        array(
            'class' => 'CButtonColumn',
            'template' => Yii::app()->user->isAdmin() ? '{view}{update}{del}' : '{view}',
            'buttons' => array (
                'del' => array (
                    'label' => 'Smazat',
                    'imageUrl' => Yii::app()->request->baseUrl . '/css/gridview/delete.png',
                    'url' => 'Yii::app()->createUrl("/title/delete", array("id"=>$data->title_id))',
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
