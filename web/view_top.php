<?
    require_once (dirname(__FILE__).'/sys/core.php');
    $GLOBALS['video_id'] = $_GET['video_id'];
    //require_once (dirname(__FILE__).'/request/get_top_comments.php');
    if($prefix == ''){
        $prefix = 'eliseev_';
    }
    
    $request = new request($prefix);
    $request->get_top_comments();
    
    if($error){
        header("HTTP/1.0 404 Not Found");
        include (dirname(__FILE__).'/user/404.php');
        die();
    }
    
?>
<!DOCTYPE>
<html>
<head>
	<link rel="shortcut icon" href="/favicon/favicon.ico" type="image/x-icon">
	<title>Список чатов к видео</title>
<?/*
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap/bootstrap.min.js"></script>	
	<script src="./js/offcanvas.js"></script>
	<link rel="stylesheet" type="text/css" href="./css/offcanvas.css" />	
	<link rel="stylesheet" type="text/css" href="./css/newstyle.css" />
*/?>
    <link rel="stylesheet" type="text/css" href="/css/view/ucompress.css" />
    <script type="text/javascript" src="/js/user/ucompress.js"></script>
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
            font-size: 3.5rem;
            }
        }
        @media (min-width:992px) {
            .container {
                max-width: 1140px;
            }
        }
    </style>
    <?require_once (dirname(__FILE__).'/template/metrica.php');?>
</head>
<body>
<?require_once (dirname(__FILE__).'/template/top_menu.php');?>

<main role="main" class="container">


  <div class="my-3 p-3 bg-white rounded shadow-sm">
    <h6 class="border-bottom border-gray pb-2 mb-0">Закрепленные чаты</h6>
    <?foreach ($request->list_topcomments as $key => $item) {?>
    <div class="media text-muted pt-3">
        <div class="block_avatar">
            <img  class="bd-placeholder-img mr-2 rounded" width="32" height="32" src="<?=$request->listusers[$item['user_id']]['avatar_url'];?>">
            <a class="counter" href="videodetail.php?id=<?=$item['id_youtube']?>"><?=$item['count_reply']?></a>
        </div>
        <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
            <strong class="d-block text-gray-dark"><?=$request->listusers[$item['user_id']]['username'];?><span class="data"><?=date("H:i:s", strtotime($item['date']));?></span></strong>
            
            <?=$item['comment'];?>
        </p>
    </div>
    <?}?>
  </div>
</main>
<?require_once (dirname(__FILE__).'/template/feedback.php');?>
</body>
</html> 
