<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/title.css" />

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

    <body>
        <div id="mainmenu">
            <div class="container">
                <div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>    
                <?php
                $this->widget('zii.widgets.CMenu', array(
                    'items' => array(
                        array('label' => 'Domů', 'url' => array('/site/index')),
                        array('label' => 'Filmy', 'url' => array('/title/index')),
                        array('label' => 'Výpůjčky', 'url' => array('/customer/borrowings'), 'visible' => !Yii::app()->user->isGuest && !Yii::app()->user->isAdmin()),
                        array('label' => 'Přihlášení', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
                        array('label' => 'Registrace', 'url' => array('/site/register'), 'visible' => Yii::app()->user->isGuest),
                        array('label' => 'Administrace', 'url' => array('/admin/index'), 'visible' => Yii::app()->user->isAdmin()),
                        array('label' => 'O Nás', 'url' => array('/site/page', 'view' => 'about')),
                        array('label' => 'Kontakt', 'url' => array('/site/contact')),
                        array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest),
                    ),
                ));
                ?>
            </div>
        </div><!-- mainmenu -->

        <div class="container" id="page">
            <div class="container container-top">
                <?php echo CHtml::image(Yii::app()->params['imageUrl'] . '/css/top.png', 'logo', array('id' => 'top')) ?>
            </div>
            <div>
                <div>
                    <div id="left-sidemenu">
                        <div class="container" style="width: 80px">
                            <ul>
                                <li>
                                    <?php
                                    echo CHtml::link(
                                            CHtml::image(Yii::app()->params['imageUrl'] . '/icons/movies.png', 'Filmy')
                                            , array('/title/index'), array('title' => 'Filmy'));
                                    ?>
                                </li>
                                <li>
                                    <?php
                                    echo CHtml::link(
                                            CHtml::image(Yii::app()->params['imageUrl'] . '/icons/home.png', 'Domů')
                                            , array('/site/index'), array('title' => 'Domů'));
                                    ?>
                                </li>
                                <?php if (Yii::app()->user->isGuest): ?> 
                                    <li>
                                        <?php
                                        echo CHtml::link(
                                                CHtml::image(Yii::app()->params['imageUrl'] . '/icons/login.png', 'Přihásit')
                                                , array('/site/login'), array('title' => 'Příhlásit'));
                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        echo CHtml::link(
                                                CHtml::image(Yii::app()->params['imageUrl'] . '/icons/register.png', 'Registrovat')
                                                , array('/site/register'), array('title' => 'Registrovat'));
                                        ?>
                                    </li>
                                <?php else : ?>
                                    <li>
                                        <?php
                                        echo CHtml::link(
                                                CHtml::image(Yii::app()->params['imageUrl'] . '/icons/logout.png', 'Odhlásit')
                                                , array('/site/logout'), array('title' => 'Odhlásit'));
                                        ?>
                                    </li>
                                <?php endif; ?>
<!--                                <li>
                                    < ?php
                                    echo CHtml::link(
                                            CHtml::image(Yii::app()->params['imageUrl'] . '/icons/about.png', 'O Nás')
                                            , array('/site/page', 'view' => 'about'));
                                    ?>
                                </li>
                                <li>
                                    < ?php
                                    echo CHtml::link(
                                            CHtml::image(Yii::app()->params['imageUrl'] . '/icons/contactus.png', 'Kontaktovat')
                                            , array('/site/contact'));
                                    ?>
                                </li>-->

                                <?php if (Yii::app()->user->isAdmin() == true): ?> 
                                    <li>
                                        <?php
                                        echo CHtml::link(
                                                CHtml::image(Yii::app()->params['imageUrl'] . '/icons/admin.png', 'Admin')
                                                , array('/admin/index'), array('title' => 'Administrace'));
                                        ?>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div><!-- mainmenu -->
                </div>
                <div id="content-block">
                    <?php if (isset($this->breadcrumbs)): ?>
                        <?php
                        $this->widget('zii.widgets.CBreadcrumbs', array(
                            'links' => $this->breadcrumbs,
                        ));
                        ?><!-- breadcrumbs -->
                    <?php endif ?>

                    <?php echo $content; ?>

                    <div class="clear" id="bottom"></div>

                    <div id="footer">
                        Copyright &copy; <?php echo date('Y'); ?> by Martin &amp; Honza.<br/>
                        All Rights Reserved.<br/>
                        <?php echo Yii::powered(); ?>
                    </div><!-- footer -->
                </div>
            </div>
        </div><!-- page -->

    </body>
</html>
