<?
    require_once (dirname(__FILE__).'/sys/core.php');
    $preply_to_comment_id = $_GET['id'];
    require_once (dirname(__FILE__).'/request/get_list_top_comments.php');

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
    <title>Архив чата</title>
<?/*
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="js/tooltip/css/tooltipster.bundle.min.css" />
    <script type="text/javascript" src="js/tooltip/js/tooltipster.bundle.min.js"></script>
    <link href="css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap/bootstrap.min.js"></script>	
    <script src="./js/offcanvas.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/offcanvas.css" />	
    <link rel="stylesheet" type="text/css" href="./css/newstyle.css" />
*/?>
    <link rel="stylesheet" type="text/css" href="/css/view/ucompress.css" />
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
    <script>
        var last_comment = '<?=$list_comments[0]['id']?>';
        var last_time_comment = '<?=date("d.m.Y H:i:s", strtotime($list_comments[0]['date']));?>';
        var top_comment_id = '<?=$preply_to_comment_id?>';
        var count_noread_comments = 0;
        var animateFaviconst = 0;
        var total_count_comments = <?=$topcomment['count_reply'];?>;
        var autors_in_list = {<?foreach ($autors_in_list as $key => $value){?>"<?=$value?>":"<?=$value?>",<?}?>};	
        document.title = total_count_comments + ' из '+ total_count_comments +' :не прочитано.';
    </script>
<?/*    <script type="text/javascript" src="js/script.js"></script>*/?>
    <script type="text/javascript" src="/js/view/ucompress.js"></script>
    <?require_once (dirname(__FILE__).'/template/metrica.php');?>
</head>
<body>
<?require_once (dirname(__FILE__).'/template/top_menu.php');?>
    <div class="toasts"></div>
    <main role="main" class="container">
        <div class="error"></div>

        <div class="top_comment d-flex align-items-center p-3 my-3 text-white-50 bg-purple rounded shadow-sm autor">
            <div class="avatar">
                <img class="mr-3" src="<?=$listusers[$topcomment['user_id']]['avatar_url'];?>"  width="48" height="48">
                <span class="total_count_comments"><?=$topcomment['count_reply']?></span>
            </div>
            <div class="lh-100">
                <h6 class="mb-0 text-white lh-100"><span class="autorname"><?=$listusers[$topcomment['user_id']]['username']?></span>
                    <span class="time data"><?=date("H:i:s", strtotime($topcomment['date']))?></span>
                </h6>
                <small><?=preg_replace('/[\r\n]/sxSX', "<br>", $topcomment['comment'])?></small>
            </div>
        </div>

    
        <div class="my-3 p-3 bg-white rounded shadow-sm comment_block">


            <?foreach ($list_comments as $key => $item) {?>
            <?
            $perc_max = 100;
            $autor = '';
            foreach ($list_users as $key => $value) {
                
                //$sim = similar_text($key,substr($item['snippet']['textOriginal'], 0, 25), $perc);
                $perc = levenshtein ( $value['username'] , substr($item['comment'], 0, strlen($value['username'])) );

                if($perc_max > $perc){
                    $perc_max = $perc;
                    $autor = $value['username'];
                    $autor_chanelid = $value['user_id_youtube'];
                }
            }
            ?>
            <div class="media text-muted pt-3 comment_body <?=$item['user_id']?><?if(in_array_r($item['user_id'], $important_autors) == true){echo' important'.$important_autors[$item['user_id']];}?>">
                <div class="block_avatar">
                    <a target="_blank" href="/userdetail.php?id=<?=$item["user_id"];?>"><img  class="bd-placeholder-img mr-2 rounded avatar_image" width="32" height="32" src="<?=$listusers[$item['user_id']]['avatar_url'];?>"></a>
                    <span class="total_count_comments"><?=$listusers[$item['user_id']]['count_message'];?></span> 
                </div>
                <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                    <strong class="d-block text-gray-dark"><?=$listusers[$item['user_id']]['username'];?><span class="data"><?=date("H:i:s", strtotime($item['date']));?></span></strong>
                    <span class="comment">
                    <?
                    if(stristr($item['comment'], $autor) !== FALSE) {?>
                        <span data-tooltip-content='#tooltip_content' class='tooltips to_autor' data-to-autor='<?=$autor_chanelid;?>'>
                            <?=str_replace($autor, "<a target='_blank' href='/userdetail.php?id=$autor_chanelid'>$autor</a>", preg_replace('/[\r\n]/sxSX', "<br>", $item['comment']));?>
                        </span>
                    <?}else{?>
                        <?=str_replace($autor, "<a target='_blank' href='/userdetail.php?id=$autor_chanelid'>$autor</a>", preg_replace('/[\r\n]/sxSX', "<br>", $item['comment']));?>
                    <?}
                    ?>
                    </span>
                </p>
            </div>
            <?}?>

        </div>
        <div class="tooltip_templates"><span id="bufer_tooltip_content"></span></div>
    </main>
    <?require_once (dirname(__FILE__).'/template/feedback.php');?>
</body>
</html>
