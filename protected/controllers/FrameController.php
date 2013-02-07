<?php

class FrameController extends Controller{
	
	public function actionIndex(){
		$this->render('index');
	}
	
	public function actionAbout(){
		$this->render('about');
	}
	
	/**
	 * 授权页
	 */
	public function actionCallback(){
		// weibo POST
		//从POST过来的signed_request中提取oauth2信息
		if(!empty($_REQUEST["signed_request"])){
			$o = new SaeTOAuthV2( Yii::app()->params['WB_AKEY'] , Yii::app()->params['WB_SKEY'] );
			$data=$o->parseSignedRequest($_REQUEST["signed_request"]);
			if($data=='-2'){
				die('签名错误!');
			}else{
				$_SESSION['oauth2']=$data;
			}
		}

		//print_r($_SESSION['oauth2']);
		if (empty($_SESSION['oauth2']["user_id"])) {//若没有获取到access token，则发起授权请求
			$this->render('auth');
		} else {//若已获取到access token，则加载应用信息
			//print_r($_SESSION['oauth2']);
			$c = new SaeTClientV2(Yii::app()->params['WB_AKEY'] , Yii::app()->params['WB_SKEY'] ,$_SESSION['oauth2']['oauth_token'] ,'' );
			Yii::app()->session['api']=$c;
			$this->redirect('/');
			//setcookie( 'weibojs_'.$o->client_id, http_build_query($_SESSION['oauth2']) );
		}
	}
	
	public function actionSend(){
		$api=Yii::app()->session['api'];
		$loc=Yii::app()->params['loc'];
		$pic=$loc.str_replace("-",'',$_POST['date']).'_'.$_POST['type'].'.png';
		$tmp=$api->upload($_POST['tweet'],$pic);
		#echo  $_POST['date'].'=='.$_POST['type'].'=='.$_POST['tweet'];
		echo empty($tmp['id'])?0:1;
	}
	
}