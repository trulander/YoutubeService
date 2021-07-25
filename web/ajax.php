<?
$ajax = true;//для отключения оптимизации вывода этого скрипта
require_once (dirname(__FILE__).'/sys/core.php');
$preply_to_comment_id = isset($_POST['top_comment_id'])?$_POST['top_comment_id']:'';
$last_comment = isset($_POST['last_comment'])?$_POST['last_comment']:'';
$GLOBALS['last_time_comment'] = isset($_POST['last_time_comment'])?$_POST['last_time_comment']:'';
$GLOBALS['autors_in_list'] = isset($_POST['autors_in_list'])?$_POST['autors_in_list']:array();
$important_autor = '';
$video_id = (isset($_POST['video_id']))?$_POST['video_id']:'';
/*
$preply_to_comment_id = $_POST['top_comment_id'];
$last_comment = $_POST['last_comment'];
$GLOBALS['last_time_comment'] = $_POST['last_time_comment'];
$GLOBALS['autors_in_list'] = $_POST['autors_in_list'];
$important_autor = '';
$video_id = (isset($_POST['video_id']))?$_POST['video_id']:'';
*/

$data = '';

if($video_id !=''){
    //require_once (dirname(__FILE__).'/request/actualy.php');
    if($prefix == ''){
        $prefix = 'eliseev_';
    }
    
    $request = new request($prefix);
    $request->get_videos();
    
}else{
    //require_once (dirname(__FILE__).'/request/get_list_top_comments.php');
    exit();
}

if($last_time_comment != ''){
    if($request->list_comments){
        foreach ($request->list_comments as $key => $item) {

                if(date("d.m.Y H:i:s", strtotime($item['date'])) <= date("d.m.Y H:i:s", strtotime($last_time_comment))){
                    break;
                }else{

                
                    if($request->listusers[$item['user_id']]['important'] > 0){ // in_array_r($item['user_id'], $important_autors) == true){
                        //echo'important'.$important_autors[$item['user_id']];
                        if($important_autor < $request->listusers[$item['user_id']]['important'])$important_autor = $request->listusers[$item['user_id']]['important'];
                    }

                    $perc_max = 100;
                    $autor = '';
                    foreach ($request->list_users as $key => $value) {
                        
                        $perc = levenshtein ( $value['username'] , substr($item['comment'], 0, strlen($value['username'])) );

                        if($perc_max > $perc){
                            $perc_max = $perc;
                            $autor = $value['username'];
                            $autor_chanelid = $value['user_id_youtube'];
                        }
                    }

                    $important = in_array_r($item['user_id'], $important_autors) ? "important".$important_autors[$item['user_id']] : "";

                    $comment = (stristr($item['comment'], $autor) !== FALSE)?"<span data-tooltip-content='#tooltip_content' class='tooltips to_autor' data-to-autor='".$autor_chanelid."'>".str_replace($autor, "<a target='_blank' href='/userdetail.php?id=$autor_chanelid'>$autor</a>", preg_replace('/[\r\n]/sxSX', "<br>", $item['comment']))."</span>":str_replace($autor, "<a target='_blank' href='/userdetail.php?id=$autor_chanelid'>$autor</a>", preg_replace('/[\r\n]/sxSX', "<br>", $item['comment']));
                    $target = ($_SESSION['logged_user']['access'] == '10')?'target_to':'';

                    
                    $data .='
                    <div class="media text-muted pt-3 comment_body noread noreadnotifi '.$item["user_id"].' '.$important.'">
                        <div class="block_avatar">
                            <a target="_blank" href="/userdetail.php?id='.$item["user_id"].'"><img class="bd-placeholder-img mr-2 rounded avatar_image" width="32" height="32" src="'.$request->listusers[$item['user_id']]['avatar_url'].'"></a>
                            <span class="total_count_comments">'.$request->listusers[$item['user_id']]['count_message'].'</span> 
                        </div>
                        <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                            <strong class="d-block text-gray-dark"><span class="username '.$target.'">'.$request->listusers[$item['user_id']]['username'].'</span><span class="data">'.date("H:i:s", strtotime($item['date'])).'</span></strong>
                            <span class="comment">'.$comment.'</span>
                        </p>
                    </div>';
                }
        }

        echo json_encode(array(
            'last_comment' => $request->list_comments[0]['id_youtube'],
            'last_time_comment' => date("d.m.Y H:i:s", strtotime($request->list_comments[0]['date'])),
            'comments'=>$data,
            'was_new_video' => (isset($_POST['video_id']) && $_POST['video_id'] != $request->video_id)?'true':'false',
            'total_count_comments' => $request->topcomment['count_reply'],
            'name_top_comment' => $request->listusers[$request->topcomment['user_id']]['username'],
            'avatar_top_comment' => $request->listusers[$request->topcomment['user_id']]['avatar_url'],
            'hashtopcomment' => hash('ripemd160', $request->topcomment['comment']),
            'text_top_comment' => preg_replace('/[\x20\t]*+ [\r\n]/sxSX', "<br>", $request->topcomment['comment']),
            'time_top_comment' => date("H:i:s", strtotime($request->topcomment['date'])),
            'autors_in_list' => $request->autors_in_list,
            'important_autor' => $important_autor,
            'video_id' => $request->video_id,
            'error' => ''));
    }else{
        echo json_encode(array(
            'was_new_video' => (isset($_POST['video_id']) && $_POST['video_id'] != $request->video_id)?'true':'false',
            'total_count_comments' => $request->topcomment['count_reply'],
            'name_top_comment' => $request->listusers[$request->topcomment['user_id']]['username'],
            'avatar_top_comment' => $request->listusers[$request->topcomment['user_id']]['avatar_url'],
            'hashtopcomment' => hash('ripemd160', $request->topcomment['comment']),
            'text_top_comment' => preg_replace('/[\x20\t]*+ [\r\n]/sxSX', "<br>", $request->topcomment['comment']),
            'time_top_comment' => date("H:i:s", strtotime($request->topcomment['date'])),
            'video_id' => $request->video_id,
            'error' => ''));
    }
}else{
    echo json_encode(array('error' => 'last_time_comment is empty'));
}
?>
