<?php

class FrameController extends Controller{
	
	public function actionIndex(){
		$this->render('index');
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
		$pic=$loc.str_replace("-",'',$_REQUEST['date']).'_'.$_REQUEST['type'].'.png';
		$content=$_REQUEST['date'].' - ';
		switch($_REQUEST['type']){
			case 'day':
				$content.='中国各省白天气温';
				break;
			case 'night':
				$content.='中国各省夜间气温';
				break;
			case 'humidity':
				$content.='中国各省大气湿度';
				break;
			case 'pressure':
				$content.='中国各省大气压';
				break;
			case 'visibility':
				$content.='中国各省能见度';
			break;
		}
		$content.=' - 关注@Conan_Z @每日中国天气 '.'http://apps.weibo.com/chinaweatherapp';
		$tmp=$api->upload($content,$pic);
		echo empty($tmp['id'])?0:1;
	}
	
}