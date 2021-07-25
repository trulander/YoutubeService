<?
require_once (dirname(__FILE__).'/sys/core.php');

//require 'sys/db_user.php';
//require_once (dirname(__FILE__).'/request/get_list_videos.php');

    if($prefix == ''){
        $prefix = 'eliseev_';
    }
    
    $request = new request($prefix);
    $request->get_list_videos();

//$autors_in_list;

?>
<!doctype html>
<html>
<head>
	<link rel="shortcut icon" href="/favicon/favicon.ico" type="image/x-icon">
	<title>Список видео</title>
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
        .container {
            margin-top: 50px;
        }
        @media (min-width:992px) {
            .container {
                margin-top: 30px;
            }
        }
        .card-body{
                min-height: 300px;
            }
            .card-text {
                height: 38%;
            }
            .text-muted {
                width: 70px;
            }
    </style>
<?require_once (dirname(__FILE__).'/template/metrica.php');?>
</head>
<body>
<?require_once (dirname(__FILE__).'/template/top_menu.php');?>


<main role="main" class="container">

    <div class="container">
        <div class="row">
            <?foreach($request->list_videos as $key => $item){?>
                <div class="col-lg-4">
                    <div class="card mb-4 shadow-sm">
                        <iframe width="100%" height="225" src="https://www.youtube.com/embed/<?=$item['id_youtube']?>" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <?/*<img class="bd-placeholder-img card-img-top" width="100%" height="225" src="<?=$item['image_url'];?>">*/?>
                        <div class="card-body">
                            <p class="card-text"><?=$item['title']?></p>
                            <p class="card-text"><?=mb_strimwidth($item['description'], 0, 100, "...");?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a target="_blank" href="https://www.youtube.com/watch?v=<?=$item['id_youtube']?>" class="btn btn-sm btn-outline-secondary">На youtube</a>
                                    <a href="view_top.php?video_id=<?=$item['id_youtube']?>" class="btn btn-sm btn-outline-secondary">Список чатов</a>
                                </div>
                                <small class="text-muted"><?=$item['date'];?></small>
                            </div>
                        </div>
                    </div>
                </div>
            <?}?>   
        </div>
    </div>

</main>

<?require_once (dirname(__FILE__).'/template/feedback.php');?>

</body>
</html>
