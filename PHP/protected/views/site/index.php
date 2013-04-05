<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Vítejte<i> v informačním systému Videopůjčovny!</h1>

<p>
   
</p>

<center>
    <table id="index">
        <thead>
            <tr>
                <td>
                    Nabídka filmů
                </td>
                <td>
                    Přihlásit
                </td>
                <td>
                    Registrovat
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <?php 
                        $img = CHtml::image(Yii::app()->params['imageUrl'] . '/icons/movie-big.png');
                        echo CHtml::link($img, array('/title/index'), array('title' => 'Filmy'));
                    ?>
                </td>
                <td>
                    <?php 
                        $img = CHtml::image(Yii::app()->params['imageUrl'] . '/icons/login-big.png');
                        echo CHtml::link($img, array('/site/login'), array('title' => 'Přihlásit'));
                    ?>
                </td>
                <td>
                    <?php 
                        $img = CHtml::image(Yii::app()->params['imageUrl'] . '/icons/reg-big.png');
                        echo CHtml::link($img, array('/site/register'), array('title' => 'Registrovat'));
                    ?>
                </td>
            </tr>
        </tbody>
    </table>
</center>
    