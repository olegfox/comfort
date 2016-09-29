function onli(){
	document.getElementById("li1").onmouseover=function(){document.getElementById('a0').style.color='#060404';};
	document.getElementById("ul1").onmouseover=function(){document.getElementById('a0').style.color='#060404';};
	$("#ul1 a").click(function(){
		$.get("/session.php",{"click":this.id}, function(data){});
	}
	);
	if((window.location.href!="http://www.kuhni-max.ru/")&&(window.location.href!="http://kuhni-max.ru/")){
	//$.get("/session.php",function(data){
		//if(data!=""){
			//$("#li1").removeAttr("style");
			$(".menu #a0").css({"color":"black"});
			$(".menu #a0").hover(
				function(){
					$(".menu #a0").css({"color":"black"});
				},
				function(){
					$(".menu #a0").css({"color":"black"});
				}
			);
			//idd="#"+data;
			/*$(idd).css({"color":"black"});
			$(idd).hover(
				function(){
					$(idd).css({"color":"black"});
				},
				function(){
					$(idd).css({"color":"black"});
				}
			);*/
			//alert($("#li1").css);
			$("#ul1").css({"display":"block", "margin":"0", "position":"absolute", "background":"none", "text-align":"left", "line-height":"60px", "height":"60px"}); 
			if($.browser.msie  && ($.browser.version == '9.0')){
				$("#ul1").css({"display":"block", "margin":"0", "position":"absolute", "background":"none", "text-align":"left", "line-height":"70px", "height":"70px"}); 
			}
			if($.browser.msie  && ($.browser.version == '8.0')){
				$("#ul1").css({"display":"block", "margin":"0", "position":"absolute", "background":"none", "text-align":"left", "line-height":"60px", "height":"60px"}); 
			}			
			if($.browser.opera){
				$("#ul1").css({"display":"block", "margin":"0", "position":"absolute", "background":"none", "text-align":"left", "line-height":"70px", "height":"70px"}); 
			}
			$("#ul1 li").css({"padding":"0 10px 0 0px"});
		//}
	//});
	}
	else{
		document.getElementById("li1").onmouseout=function(){document.getElementById('a0').style.color='#545251';};
		document.getElementById("ul1").onmouseout=function(){document.getElementById('a0').style.color='#545251';};
	}
}
function height(){
	check=0;
	if($.browser.msie && ($.browser.version == '9.0')){
		$(document).ready(function() { 
			if($(document).height()<1570){
				$.post("../modules/function.php",{"count":"3"},function(data){$(".kitchenEx").html(data);});
			}
			else{
				$.post("../modules/function.php",{"count":"2"},function(data){$(".kitchenEx").html(data);});
			}
			$('.all').css('height',$(document).height()+30);	
		});
		check=1;
	}
	if (($.browser.msie) && ($.browser.version == '8.0')) {
	
	//alert($(document).height());
		$(document).ready(function() { 
			if($(document).height()<1570){
				$.post("../modules/function.php",{"count":"3"},function(data){/*if($(".kitchenEx")){*/$(".kitchenEx").html(data);/*}*/});
			}
			else{
				$.post("../modules/function.php",{"count":"2"},function(data){$(".kitchenEx").html(data);});
			}
			$('.all').css('height',$(document).height()+50);	
		});
		check=1;
	}
	if($.browser.opera && $.browser.version!="12.00"){
		$(document).ready(function() { 
			if($(document).height()<1540){
				$.post("../modules/function.php",{"count":"3"},function(data){$(".kitchenEx").html(data);});
			}
			else{
				$.post("../modules/function.php",{"count":"2"},function(data){$(".kitchenEx").html(data);});
			}
			$('.all').css('height',$(document).height()+230);	
		});
		check=1;
	}
	/*if($.browser.opera && $.browser.version=="12.00"){
		$(document).ready(function() { 
			if($(document).height()<1540){
				$.post("../modules/function.php",{"count":"3"},function(data){$(".kitchenEx").html(data);});
			}
			else{
				$.post("../modules/function.php",{"count":"2"},function(data){$(".kitchenEx").html(data);});
			}
			$('.all').css('height',$(document).height()+50);	
		});
		check=1;
	}*/	
	if(check==0){
		$(document).ready(function() { 
			if($(document).height()<1550){
				$.post("../modules/function.php",{"count":"3"},function(data){$(".kitchenEx").html(data);});
			}
			else{
				$.post("../modules/function.php",{"count":"2"},function(data){$(".kitchenEx").html(data);});
			}
			$('.all').css('height',$(document).height()+50);	
		});
	}
	//$('.footer').css('margin-top',"195px");
}
function height2(){
	if($.browser.opera){
		if($.browser.version!="12.00"){
			if($(document).height()==941){
				$('.all').css('height',$(document).height()+500);
			}
			else{
				$('.all').css('height',$(document).height()+500);
			}
		}
		else{
			if($(document).height()==941){
				$('.all').css('height',$(document).height()+470);
			}
			else{
				$('.all').css('height',$(document).height()+470);
			}		
		}
	}
	else{
	setTimeout(function(){
		if($(document).height()==941){
			$('.all').css('height',$(document).height()+500);
		}
		else{
			$('.all').css('height',$(document).height()+50);
		}
	},1000);
	}
}
