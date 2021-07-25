<?
require_once (dirname(__FILE__).'/sys/core.php');
    if($prefix == ''){
        $prefix = 'eliseev_';
    }
    $request = new request($prefix);

    if(isset($_POST['message-text']) && $_POST['message-text'] != ''){
            $request->feedback_save_message($_POST['message-text']);
            header('Location: https://youtube.kesok.ru/feedback.php');
            exit();
    }
    $request->feedback();
    //print_r($_SESSION['logged_user']);
    //print_r($request->response);


//require 'sys/db_user.php';
///require_once (dirname(__FILE__).'/request/feedback.php');

?>
<!doctype html>
<html>
<head>
	<link rel="shortcut icon" href="/favicon/favicon.ico" type="image/x-icon">
	<title>Внутренний чат</title>
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
        <div class="my-3 p-3 bg-white rounded shadow-sm comment_block">
            <?foreach ($request->list_comments as $key => $item) {?>
            <div class="media text-muted pt-3 comment_body">
                <div class="block_avatar">
                    <img  class="bd-placeholder-img mr-2 rounded avatar_image" width="32" height="32" src="/images/photo.jpg">
                </div>
                <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                    <strong class="d-block text-gray-dark"><span class="username"><?=$request->listusers[$item['from']];?></span><span class="data"><?=date("Y-m-d H:i:s", strtotime($item['date']));?></span></strong>
                    <span class="comment">
                        <?=preg_replace('/[\r\n]/sxSX', "<br>", $item['comment']);?>
                    </span>
                </p>
            </div>
            <?}?>
        </div>
    </main>

<?require_once (dirname(__FILE__).'/template/feedback.php');?>

</body>
</html>
