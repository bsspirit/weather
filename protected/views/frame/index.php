<?php
	$date=empty($_REQUEST['date'])?date("Y-m-d"):$_REQUEST['date'];
	$type=empty($_REQUEST['type'])?'day':$_REQUEST['type'];
	$vdate=str_replace("-",'',$date);
	echo '<div id="today" date="'.date("Ymd").'"></div>';
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
		气温：<a href="javascript:void(0);" <?php echo $type=='day'?'':'onclick="forward(this)"';?> type='day'><span <?php echo $type=='day'?'class="current"':'class="btn"'?>>白天</span></a>
		<a href="javascript:void(0);" <?php echo $type=='night'?'':'onclick="forward(this)"';?> type='night'><span <?php echo $type=='night'?'class="current"':'class="btn"'?>>夜间</span></a>
	</div>
	<!-- 
	<div class="row">
		温度&nbsp;&nbsp;&nbsp;&nbsp;风力&nbsp;&nbsp;&nbsp;&nbsp;空气质量
	</div>
	 -->
</div>

<div class="view">
	<div class="row">
		<a href="javascript:void(0);" onclick="share()">
			<span class="bigbtn">分享</span>
		</a>
	</div>
</div>

<div style="text-align:center;margin:0 auto;">
	<img id="mp" src="<?php echo Yii::app()->request->baseUrl;?>/images/w/<?php echo $vdate?>_<?php echo $type?>.png" width=600px height=600px/>
</div>


<script type="text/javascript">
String.prototype.replaceAll  = function(s1,s2){   
	return this.replace(new RegExp(s1,"gm"),s2);   
}

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

var share=function(){
	var date=$("#publishDate").val();
	var type=$('.current').parent().attr('type');
	//alert(date+type);

	$.ajax({
	  url: '/frame/send?date='+date+"&type="+type,
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