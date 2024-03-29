<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<meta charset="utf-8" />
	<title>移动场景系统后台管理登陆</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="Public/media/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="Public/media/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
	<link href="Public/media/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
	<link href="Public/media/css/style-metro.css" rel="stylesheet" type="text/css"/>
	<link href="Public/media/css/style.css" rel="stylesheet" type="text/css"/>
	<link href="Public/media/css/style-responsive.css" rel="stylesheet" type="text/css"/>
	<link href="Public/media/css/default.css" rel="stylesheet" type="text/css" id="style_color"/>
	<link href="Public/media/css/uniform.default.css" rel="stylesheet" type="text/css"/>
	<!-- END GLOBAL MANDATORY STYLES -->
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link href="Public/media/css/login-soft.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="Public/media/js/tooltips.js"></script>
	<!-- END PAGE LEVEL STYLES -->
	<link rel="shortcut icon" href="Public/media/image/favicon.ico" />
</head>

<!-- END HEAD -->

<!-- BEGIN BODY -->

<body class="login">

	<!-- BEGIN LOGO -->

	<div class="logo">

		<img src="assets/admin/logo.png" alt="" /> 

	</div>

	<!-- END LOGO -->

	<!-- BEGIN LOGIN -->

	<div class="content">

		<!-- BEGIN LOGIN FORM -->

        <form action="/adminc.php?c=auth&a=login" id="login_form" method="post" class="form-vertical login-form">

			<h3 class="form-title">管理员登陆</h3>

			<div class="alert alert-error hide">

				<button class="close" data-dismiss="alert"></button>

				<span>Enter any username and password.</span>

			</div>

			<div class="control-group">
            
			

				

				<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->

				<label class="control-label visible-ie8 visible-ie9">请输入管理员用户名</label>

				<div class="controls">

					<div class="input-icon left">

						<i class="icon-user"></i>
<input id="email" value="" name="username" type="text" class="m-wrap placeholder-no-fix x319 in" placeholder="请填写管理员邮箱">
					

					</div>

				</div>

			</div>

			<div class="control-group">

			

				<div class="controls">

					<div class="input-icon left">

						<i class="icon-lock"></i>

		<input class="m-wrap placeholder-no-fix" type="password"  name="password" id="password" placeholder="请输入密码"/>

					</div>

				</div>

			</div>
            
            	<div class="controls">
                        
                
                
                
                
                
                
          <div class="input-icon left">
          
          
          
                 <i class="icon-euro"></i>
                  <input type="text" id="verify" name="verify" placeholder="请填写验证码" autocomplete="off"  class="m-wrap placeholder-no-fix" >
                  
                   <a id="captcha-container" class="reloadverify" title="换一张" href="javascript:void(0)"> 

                    <img class="verifyimg reloadverify" alt="点击切换" src="<?php echo U('Auth/verify');?>" width="290" >  </a>      

                  
                  
<div class="input-icon left">
		 

					</div>

				</div>
		  <div class="form-actions">
			  <label class="checkbox">
				<input type="checkbox" name="remember" value="1"/> 保存密码
			  </label>
				<button type="button" id="submit_btn" class="btn blue pull-right">进入管理 <i class="m-icon-swapright m-icon-white"></i>
				</button>            
			</div>

		</form>
		<!-- END LOGIN FORM -->        
		<!-- END REGISTRATION FORM -->
	</div>
	<!-- END LOGIN -->
	<!-- BEGIN COPYRIGHT -->
	<div class="copyright">
		2015 &copy; 微上宝 版权所有
	</div>
	<!-- BEGIN CORE PLUGINS -->
	<script src="Public/media/js/jquery-1.10.1.min.js" type="text/javascript"></script>
	<script src="Public/media/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
	<script src="Public/media/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>      
	<script src="Public/media/js/bootstrap.min.js" type="text/javascript"></script>
	<!--[if lt IE 9]>
	<script src="Public/media/js/excanvas.min.js"></script>
	<script src="Public/media/js/respond.min.js"></script>  
	<![endif]-->   
	<script src="Public/media/js/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="Public/media/js/jquery.blockui.min.js" type="text/javascript"></script>  
	<script src="Public/media/js/jquery.cookie.min.js" type="text/javascript"></script>
	<script src="Public/media/js/jquery.uniform.min.js" type="text/javascript" ></script>
	<!-- END CORE PLUGINS -->

	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script src="Public/media/js/jquery.validate.min.js" type="text/javascript"></script>
	<script src="Public/media/js/jquery.backstretch.min.js" type="text/javascript"></script>
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="Public/media/js/app.js" type="text/javascript"></script>
	<script src="Public/media/js/login-soft.js" type="text/javascript"></script>      
	<!-- END PAGE LEVEL SCRIPTS --> 
    

    
     <script type="text/javascript">
// 验证码生成  
var captcha_img = $('#captcha-container').find('img')  
var verifyimg = captcha_img.attr("src");  
captcha_img.attr('title', '点击刷新');  
captcha_img.click(function(){  
    if( verifyimg.indexOf('?')>0){  
        $(this).attr("src", verifyimg+'&random='+Math.random());  
    }else{  
        $(this).attr("src", verifyimg.replace(/\?.*$/,'')+'?'+Math.random());  
    }  
}); 
    </script>   
    
    
    
    
    
    
    
	<script>
		jQuery(document).ready(function() {     
		  App.init();
		  Login.init();
		});
	</script>
	<!-- END JAVASCRIPTS -->
<script type="text/javascript">  var _gaq = _gaq || [];  _gaq.push(['_setAccount', 'UA-37564768-1']);  _gaq.push(['_setDomainName', 'keenthemes.com']);  _gaq.push(['_setAllowLinker', true]);  _gaq.push(['_trackPageview']);  (function() {    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);  })();</script></body>

<!-- END BODY -->

</html>