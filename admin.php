<?php
$rt_s = strtok(microtime(), " ") + strtok(" ");
error_reporting(E_ALL);
define('MODE', 1);
@ini_set('default_charset', 'UTF-8');
ob_start('ob_gzhandler');
session_start();
require_once('include/mysqli.php');
$db = new MySQL('localhost', 'clickndrink', 'buuusn', 'clickndrink');
#@ini_set('session.name', 'SID');
//require_once('includes/mysql.class.php');
// require_once('admin/includes/loader.php');
// $db = new Database('localhost','ho130210002sql1','teamfighter','ho130210002sql1',true);
$module = htmlspecialchars($_GET['module']);
$failed_module=null;
if(!isset($_GET['module']) || $module=='')
{
    $module = 'login';
}
elseif(!file_exists('modules/admin/'.$module.'.module.php')) {
    $failed_module = $module;
    $module = '404';
//     header("HTTP/1.1 404 Not Found");
}

$_SESSION['logged_in']=true;
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Click 'n' Drink - Admincenter</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="media/css/normalize.css">
        <link rel="stylesheet" href="media/css/admin.css">
		<link rel="stylesheet" href="media/css/jqueryui/jquery-ui-1.10.3.custom.min.css">

        <script src="media/js/vendor/modernizr-2.6.2.min.js"></script>
		<script type="text/javascript">var sid = '<?php echo session_id() ?>';</script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
	<div id="main">
	<?php if($module!='login' && $module!='404') { ?>
		<ul id="navi">
			<li class="heading"><h2>Main</h2></li>
			<li><a href="?module=editor">Cocktail Editor</a></li>
			<li><a href="?module=ing_editor">Ingredient Editor</a></li>
			<li><a href="?module=site_editor">Site Editor</a></li>
			<li><a href="?module=logout">Logout</a></li>
		</ul>
	<?php } ?>
		
		<div id="content">
                <?php
//                 if($failed==null)
//                 {
                   require_once('modules/admin/'.$module.'.module.php');
//                 }
//                 else
// 				{
//                    echo 'Module "'.$failed_module.'" doesn\'t exists. Remember that in such cases the IP will be logged!<br />
//                    Please don\'t try do XSS or DDOS us, we aren\'t worth it ;)
//                    ';
// 				}
                ?>
		</div>
	</div>
		
        <!-- Content end -->
<!--		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="media/js/vendor/jquery-1.8.3.min.js"><\/script>')</script>-->
		<script src="media/js/vendor/jquery-1.8.3.min.js"></script>
		<script src="media/5grid/init.js"></script>
		<script src="media/js/plugins.js"></script>
		<script src="media/js/admin.js"></script>
    </body>
</html>
<?php
$rt_e = strtok(microtime(), " ") + strtok(" ");
echo '<!-- Runtime: ' . number_format(($rt_e - $rt_s)*1000, 6) . ' ms -->';
ob_end_flush();
?>