<?
    require_once (dirname(__FILE__).'/sys/core.php');
    $GLOBALS['user_id'] = $_GET['id'];
    //require_once (dirname(__FILE__).'/request/get_list_user_comments.php');
    if($prefix == ''){
        $prefix = 'eliseev_';
    }

    $request = new request($prefix);
    $request->get_list_user_comments();    

    if($error){
        header("HTTP/1.0 404 Not Found");
        include (dirname(__FILE__).'/user/404.php');
        die();
    }    
//print_r($list_comments);

?>
<!DOCTYPE>
<html>
<head>
	<link rel="shortcut icon" href="/favicon/favicon.ico" type="image/x-icon">
	<title>Топ пользователей</title>
<?/*
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap/bootstrap.min.js"></script>	
	<link rel="stylesheet" type="text/css" href="./js/tooltip/css/tooltipster.bundle.min.css" />
	<script src="./js/offcanvas.js"></script>
	<link rel="stylesheet" type="text/css" href="./css/offcanvas.css" />	
	<link rel="stylesheet" type="text/css" href="./css/newstyle.css" />
*/?>

    <link rel="stylesheet" type="text/css" href="/css/view/ucompress.css" />
    <script type="text/javascript" src="/js/user/ucompress.js"></script>
    <?require_once (dirname(__FILE__).'/template/metrica.php');?>
</head>
<body>
<?require_once (dirname(__FILE__).'/template/top_menu.php');?>
<main role="main" class="container">




  <div class="my-3 p-3 bg-white rounded shadow-sm comment_block">


    <?foreach ($request->list_comments as $key => $item) {?>
    <div class="media text-muted pt-3 comment_body">
        <div class="block_avatar">
            <img  class="bd-placeholder-img mr-2 rounded avatar_image" width="32" height="32" src="<?=$request->user['avatar_url'];?>">         
        </div>
        <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
            <strong class="d-block text-gray-dark"><?=$request->user['username'];?><span class="data"><?=date("d.m.Y H:i:s", strtotime($item['date']));?></span></strong>
            <?=$item['comment']?>
        </p>
    </div>
    <?}?>

  </div>



</main>
<?require_once (dirname(__FILE__).'/template/feedback.php');?>
</body>
</html> 
