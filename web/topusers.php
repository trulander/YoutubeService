<?
require_once (dirname(__FILE__).'/sys/core.php');
//require_once (dirname(__FILE__).'/request/get_list_users.php');
if($prefix == ''){
        $prefix = 'eliseev_';
}

$request = new request($prefix);
$request->get_list_users();

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
      .card-body{
            min-height: 300px;
        }
        .card-text {
            height: 38%;
        }
        .text-muted {
            width: 180px;
        }
        .comment_body .small{
            min-height: 60px;
        }
</style>
<?require_once (dirname(__FILE__).'/template/metrica.php');?>
</head>
<body>
<?require_once (dirname(__FILE__).'/template/top_menu.php');?>

<main role="main" class="container">

<div class="container">
    <div class="row">

    <?foreach ($request->listusers as $key => $item) {?>

    <div class="media text-muted pt-3 comment_body <?=$item['user_id_youtube']?>">
        <div class="block_avatar">
            <a href="/userdetail.php?id=<?=$item["user_id_youtube"];?>"><img  class="bd-placeholder-img mr-2 rounded avatar_image" width="32" height="32" src="<?=$request->listusers[$item['user_id_youtube']]['avatar_url'];?>"></a>
            <span class="total_count_comments"><?=$request->listusers[$item['user_id_youtube']]['count_message'];?></span> 
        </div>
        <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
            <strong class="d-block text-gray-dark"><?=$request->listusers[$item['user_id_youtube']]['username'];?></strong>
        </p>
    </div>
    <?}?>
    
    </div>
</div>
</main>
<?require_once (dirname(__FILE__).'/template/feedback.php');?>
</body>
</html> 
