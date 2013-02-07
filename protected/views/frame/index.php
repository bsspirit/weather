<?php
	$date=empty($_REQUEST['date'])?date("Y-m-d"):$_REQUEST['date'];
	$type=empty($_REQUEST['type'])?'code':$_REQUEST['type'];
	$vdate=str_replace("-",'',$date);
	echo '<div id="today" date="'.date("Ymd").'"></div>';
	
	function getContent($date,$type){
		$content='我正在使用【每日中国天气】，非常棒的天气效果，大家都来试试哈！';
		$content.=$date.' - ';
		switch($type){
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
			case 'code':
				$content.='中国各省天气概况';
				break;
		}
		$content.=' http://apps.weibo.com/chinaweatherapp'.' @Conan_Z @每日中国天气';
		return $content;
	}
?>
<div class="view">
	<div class="row">
		日期: <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
				    'name'=>'publishDate',
					'value'=>$date,
				    'options'=>array(
				        'showAnim'=>'fold',
				    	'dateFormat'=>'yy-mm-dd',
				    ),
				    'htmlOptions'=>array(
				        'style'=>'height:18px;'
				    ),
			 ));?>
	</div>
	<hr/>
	<div class="row">
		总体：<a href="javascript:void(0);" <?php echo $type=='code'?'':'onclick="forward(this)"';?> type='code'><span <?php echo $type=='code'?'class="current"':'class="btn"'?>>概况</span></a>	
	</div>
	<div class="row">
		气温：<a href="javascript:void(0);" <?php echo $type=='day'?'':'onclick="forward(this)"';?> type='day'><span <?php echo $type=='day'?'class="current"':'class="btn"'?>>白天</span></a>
		<a href="javascript:void(0);" <?php echo $type=='night'?'':'onclick="forward(this)"';?> type='night'><span <?php echo $type=='night'?'class="current"':'class="btn"'?>>夜间</span></a>
	</div>
	<div class="row">
		大气：<a href="javascript:void(0);" <?php echo $type=='humidity'?'':'onclick="forward(this)"';?> type='humidity'><span <?php echo $type=='humidity'?'class="current"':'class="btn"'?>>湿度</span></a>
		<a href="javascript:void(0);" <?php echo $type=='pressure'?'':'onclick="forward(this)"';?> type='pressure'><span <?php echo $type=='pressure'?'class="current"':'class="btn"'?>>大气压</span></a>
		<a href="javascript:void(0);" <?php echo $type=='visibility'?'':'onclick="forward(this)"';?> type='visibility'><span <?php echo $type=='visibility'?'class="current"':'class="btn"'?>>能见度</span></a>
	</div>
</div>

<div class="view ">
	<!-- 
	<div class="row">
		<a href="javascript:void(0);" onclick="share()">
			<span class="bigbtn">分享</span>
		</a>
	</div>
	 -->
	<div class="row">
		<textarea id=tweet rows="3" cols="73"><?php echo getContent($date,$type);?></textarea>
		&nbsp;
		<a href="javascript:void(0);" onclick="at(this)" title="@每日中国天气">
			<img src="images/logo-80.png" width="55" alt="@每日中国天气"/>
		</a>&nbsp;
		<a href="javascript:void(0);" onclick="at(this)" title="@Conan_Z">
			<img src="images/my.jpg" width=55 alt="@Conan_Z"/>
		</a>&nbsp;
	</div>
	<div class="row">
		<a href="javascript:void(0);" onclick="share()">
			<span class="bigbtn">分享到微博</span>
		</a>
		<span style="margin-left:200px;color:gray;">谢谢你的支持，我会做得更好！</span>
	</div>
	<div class="c"></div>
</div>

<div style="text-align:center;margin:0 auto;">
	<img id="mp" src="<?php echo Yii::app()->request->baseUrl;?>/images/w/<?php echo $vdate?>_<?php echo $type?>.png" width=600px height=600px/>
</div>

<script type="text/javascript">
String.prototype.replaceAll  = function(s1,s2){   
	return this.replace(new RegExp(s1,"gm"),s2);   
}
String.prototype.contains = function(item){
    return RegExp(item).test(this);
};

$("#publishDate").change(function(){
	var date=$("#publishDate").val();
	var today=$('#today').attr('date');

	var cdate=date.replaceAll('-', '');
	if(cdate>today){
		alert('选择日期不能大于当前日期！');
	}else if(cdate<20130201){
		alert('选择日期不能小于2013-02-01，应用上线时间！');
	}else{
		var type=$('.current').parent().attr('type');
		window.location.href='?date='+date+"&type="+type;
	}
});

$(".bigbtn").hover(function(){
	 $(this).addClass("bigbtn-hover");	
},function(){
	 $(this).removeClass("bigbtn-hover");
});

var forward=function(obj){
	var date=$("#publishDate").val();
	var type=$(obj).attr('type');
	window.location.href='?date='+date+"&type="+type;	
}

var at=function(obj){
	var title = $(obj).attr("title");
	var tobj=$('#tweet');
	var tweet = tobj.text();
	if(tweet.contains(title)){
		tweet=tweet.replace(title, '');
	}else{
		tweet+=' '+title;
	}
	tobj.text(tweet);
}

var share=function(){
	var date=$("#publishDate").val();
	var type=$('.current').parent().attr('type');
	var tweet=$('#tweet').text();
	$.ajax({
	  url: '/frame/send',
	  type:'POST',
	  data:{tweet:tweet,date:date,type:type},
	  success: function(obj){
		  if(obj=='1'){
			  alert("成功分享到新浪微博!");
		  } else {
			  alert("发布失败!");
		  }
	  }
	});
}
</script>