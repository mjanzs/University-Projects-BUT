<?php
$this->breadcrumbs = array(
    'Administrace',
);

$this->menu = array(
    array('label' => 'Filmy', 'url' => array('/title/index')),
    array('label' => 'Logout', 'url' => array('/site/logout')),
);
?>

<h1>Administrace</h1>
<table class="admin" align="center">
    <tr>
        <td class="ico">
            <?php echo CHtml::image(Yii::app()->params['imageUrl'] . '/icons/up.png'); ?>
            <?php // echo CHtml::image(Yii::app()->params['imageUrl'] . '/icons/down.png'); ?>
        </td>
        <td>
            <span class="admin"><?php echo CHtml::link('Výpůjčky', array('/borrowing/admin')); ?></span>
        </td>
        <td class="ico">
            <?php
            $imgAdd = CHtml::image(Yii::app()->params['imageUrl'] . '/icons/add.png');
            echo CHtml::link($imgAdd, array('/borrowing/create'), array('title' => 'Přidat'));
            ?>
        </td>
        <td class="ico">
            <?php
            $img = CHtml::image(Yii::app()->params['imageUrl'] . '/icons/edit.png');
            echo CHtml::link($img, array('/borrowing/admin'), array('title' => 'Tabulka'));
            ?>
        </td>
    </tr>
    <tr>
        <td class="ico">
            <?php echo CHtml::image(Yii::app()->params['imageUrl'] . '/icons/bill.png'); ?>
        </td>
        <td>
            <span class="admin"><?php echo CHtml::link('Účtenky', array('/bill/admin')); ?></span>
        </td>
        <td class="ico">
            <?php
            //echo CHtml::link($imgAdd, array('/borrowing/create'));
            ?>
        </td>
        <td class="ico">
            <?php
            echo CHtml::link($img, array('/bill/admin'), array('title' => 'Tabulka'));
            ?>
        </td>
    </tr>
    <tr>
        <td class="ico">
            <?php echo CHtml::image(Yii::app()->params['imageUrl'] . '/icons/title.png'); ?>
        </td>
        <td>
            <span class="admin"><?php echo CHtml::link('Tituly', array('/title/admin')) ?></span>
        </td>
        <td class="ico">
            <?php
            echo CHtml::link($imgAdd, array('/title/create'), array('title' => 'Přidat'));
            ?>
        </td>
        <td class="ico">
            <?php
            echo CHtml::link($img, array('/title/admin'), array('title' => 'Tabulka'));
            ?>
        </td>
    </tr>
    <tr>
        <td class="ico">
            <?php echo CHtml::image(Yii::app()->params['imageUrl'] . '/icons/medium.png'); ?>
        </td>
        <td>
            <span class="admin"><?php echo CHtml::link('Media', array('/medium/admin')) ?></span>
        </td>
        <td class="ico">
            <?php
            echo CHtml::link($imgAdd, array('/medium/create'), array('title' => 'Přidat'));
            ?>
        </td>
        <td class="ico">
            <?php
            echo CHtml::link($img, array('/medium/admin'), array('title' => 'Tabulka'));
            ?>
        </td>
    </tr>
    <tr>
        <td class="ico">
            <?php echo CHtml::image(Yii::app()->params['imageUrl'] . '/icons/star.png'); ?>
        </td>
        <td>
            <span class="admin"><?php echo CHtml::link('Žánry', array('/genre/admin')) ?></span>
        </td>
        <td class="ico">
            <?php
            $imgAdd = CHtml::image(Yii::app()->params['imageUrl'] . '/icons/add.png');
            echo CHtml::link($imgAdd, array('/genre/create'), array('title' => 'Přidat'));
            ?>
        </td>
        <td class="ico">
            <?php
            $img = CHtml::image(Yii::app()->params['imageUrl'] . '/icons/edit.png');
            echo CHtml::link($img, array('/genre/admin'), array('title' => 'Tabulka'));
            ?>
        </td>
    </tr>
    <tr>
        <td class="ico">
            <?php echo CHtml::image(Yii::app()->params['imageUrl'] . '/icons/login.png'); ?>
        </td>
        <td>
            <span class="admin"><?php echo CHtml::link('Zákazníci', array('/customer/admin')); ?></span>
        </td>
        <td class="ico">
            <?php
            echo CHtml::link($imgAdd, array('/customer/create'), array('title' => 'Přidat'));
            ?>
        </td>
        <td class="ico">
            <?php
            echo CHtml::link($img, array('/customer/admin'), array('title' => 'Tabulka'));
            ?>
        </td>
    </tr>
    <?php if (Yii::app()->user->isSuperAdmin()): ?>
        <tr>
            <td class="ico">
                <?php echo CHtml::image(Yii::app()->params['imageUrl'] . '/icons/group.png'); ?>
            </td>
            <td>
                <span class="admin"><?php echo CHtml::link('Zaměstnanci', array('/employee/admin')); ?></span>
            </td>
            <td class="ico">
                <?php
                echo CHtml::link($imgAdd, array('/employee/create'), array('title' => 'Přidat'));
                ?>
            </td>
            <td class="ico">
                <?php
                echo CHtml::link($img, array('/employee/admin'), array('title' => 'Tabulka'));
                ?>
            </td>
        </tr>    
    <?php endif; ?>
</table>

<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
