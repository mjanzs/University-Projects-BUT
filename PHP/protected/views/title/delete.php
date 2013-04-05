<?php
/* @var $this TitleController */
/* @var $model Title */

$this->breadcrumbs = array(
    'Titul' => array('index'),
    ucfirst('Smazat'),
    ucfirst($model->name),
);
if (Yii::app()->user->isAdmin()) {
    $this->menu = array(
        array('label' => 'Spravovat tituly', 'url' => array('admin')),
        array('label' => 'Seznam titulů', 'url' => array('index')),
        array('label' => 'Vytvořit titul', 'url' => array('create')),
        array('label' => 'Upravit', 'url' => array('update', 'id' => $model->title_id)),
        array('label' => 'Administrace', 'url' => array('/admin/index')),
    );
}
else {
    $this->menu = array(
        array('label' => 'Seznam titulů', 'url' => array('index')),
    );
}
?>

<?php
/* Check Borrowing */
$borrowings = Medium::model()->findAllByAttributes(array(
    'title_id' => $model->title_id,
        ), 'borrowing_id is not null');
/* Check Bill */
$bills = Bill::model()->findAllByAttributes(array(
    'title_id' => $model->title_id,
        ));
if ($borrowings == array() && $bills == array()) {
    ?>
    <div class="flash-success">
        Titul lze smazat.<br/><br/>
        <?php
        echo CHtml::beginForm(array('/title/deletethis', 'id' => $model->title_id), 'post');
        echo CHtml::hiddenField('Title[title_id]', $model->title_id);
        echo CHtml::submitButton('Smazat');
        echo CHtml::endForm();
        ?>
    </div>
    <?php
}
else if ($bills == array() && $borrowings != array()) {
    echo '<div class="flash-error">Titul nelze smazat. (Na titul je vázána výpůjčka)</div>';
}
else if ($borrowings == array() && $bills != array()) {
    echo '<div class="flash-error">Titul nelze smazat. (Na titul je vázána účtenka)</div>';
}
else {
    echo '<div class="flash-error">Titul nelze smazat. (Na titul je vázána výpůjčka a účtenka)</div>';
}
?>

<h1><?php echo 'Smazat titul #' . $model->title_id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'cssFile' => Yii::app()->baseUrl . '/css/detailview/styles.css',
    'data' => $model,
    'attributes' => array(
//        'title_id',
        'name',
        'director',
        array(
            'name' => 'count',
            'value' => $model->getMediumsCount($model->title_id),
        ),
        'year',
        array(
            'name' => 'new',
            'value' => $model->new ? "Ano" : "Ne",
        ),
    ),
));
?>
<hr/>
<?php
/* Mediums */
if ($borrowings != array()) {
    echo '<h2>Vypůjčená media titulu:</h2>';

    $attributes = array();
    foreach ($borrowings as $b) {
        $attributes[] = array(
            'name' => 'Medium ' . $b->medium_id,
            'type' => 'html',
            'value' => CHtml::link('Přejít na Smazat', array(
                '/medium/admin', 'Medium[medium_id]' => $b->medium_id
                    )
            ),
        );
    }

    $this->widget('zii.widgets.CDetailView', array(
        'cssFile' => Yii::app()->baseUrl . '/css/detailview/styles.css',
        'data' => $borrowings,
        'attributes' => $attributes,
    ));
}
?>
<hr/>
<?php
/* Borrowings */
if ($bills != array()) {
    echo '<h2>Účtenky titulů:</h2>';

    $attributes = array();
    foreach ($bills as $b) {
        $attributes[] = array(
            'name' => 'Účtenka ' . $b->bill_id,
            'type' => 'html',
            'value' => CHtml::link('Náhled', array('/bill/view', 'id' => $b->bill_id)),
        );
    }

    $this->widget('zii.widgets.CDetailView', array(
        'cssFile' => Yii::app()->baseUrl . '/css/detailview/styles.css',
        'data' => $bills,
        'attributes' => $attributes,
    ));
}
?>
