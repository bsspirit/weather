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
	
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<script src="http://tjs.sjs.sinajs.cn/t35/apps/opent/js/frames/client.js" language="JavaScript"></script>
</head>

<body>

<div class="container" id="page">
<!-- 
	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div>
 -->
 <!-- 
	<div id="mainmenu">
		<?php 
		//$this->widget('zii.widgets.CMenu',array(
// 			'items'=>array(
// 				array('label'=>'Home', 'url'=>array('/site/index')),
// 				array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
// 				array('label'=>'Contact', 'url'=>array('/site/contact')),
// 				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
// 				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
// 			),
// 		)); ?>
	</div>
 -->
	<?php echo $content; ?>
	<div id="footer">
		<p>Copyright &copy; bsspirit@gmail.com |
		   由 <a target="_blank" href="http://weibo.com/dotabook"><span style="color:#007898;">@Conan_Z</span></a> 开发及运营&nbsp;&nbsp;
		 <a href="/frame/about">关于作者</a>
		</p>
		<p>作者的其他应用：<a target="_blank" href="http://www.fens.me"><span style="color:#007898;">@晒粉丝</span></a></p>
		<p>专注社交网络和微博研究，精通数据挖掘和机器学习，提供专业的本土社会化数据分析解决方案.</p>
	</div>
</div><!-- page -->

</body>
</html>