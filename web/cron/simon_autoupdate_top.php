<?
$path_parts = pathinfo($_SERVER['SCRIPT_FILENAME']); // определяем директорию скрипта
chdir($path_parts['dirname']); // задаем директорию выполнение скрипта



//саймонов ключи 6 7 8
$change_apikey = 7;

if(date("H") < 14){
    //$change_apikey = 5;
}else{
    //$change_apikey = 2;
}

require_once (dirname(__FILE__).'/../sys/request.php');
require_once (dirname(__FILE__).'/../sys/google_api.php');
$prefix = 'simon_';
$request = new request($prefix);

$video_id = '';

if($ext = $db->query("SELECT `id_youtube` FROM `".$prefix."videos` ORDER BY date DESC LIMIT 1")->fetch_assoc()){
    $video_id = $ext['id_youtube'];    
}
    
    

$request->list_top($video_id,maxResults_top_comment);
//print_r($request->response);
//получаем топовый комментарий с видео и обновляем по нему информацию
//require_once (dirname(__FILE__).'/../request/list_top.php');
echo $video_id;


if(in_array_r($request->response['user_id'], $important_autors)){//если владелей комментария входит в список важных пользователей, то можно от него обновить топовый
echo'true';

    if (!$ext = $db->query("SELECT * FROM `".$prefix."top_comments` WHERE `id_youtube` = '" . $request->response['top_comment_id'] . "'")->fetch_assoc()){
        $db->query('INSERT INTO `'.$prefix.'top_comments` SET ?As', array("id_youtube" => $request->response['top_comment_id'], "user_id" => $request->response['user_id'], "id_video" => $request->response['id_video'], "date" => date("Y-m-d H:i:s", strtotime($request->response['originaltime_top_comment'])), "count_reply" => $request->response['total_count_comments'], "comment" => $request->response['text_top_comment'],"update_date" => date("Y-m-d H:i:s")));
    }else{
        $data["comment"] = $request->response['text_top_comment'];
        $data["count_reply"] = $request->response['total_count_comments'];
        $data["update_date"] = date("Y-m-d H:i:s");
        $dt = array();
        foreach ($data as $key => $val) 
        {
            $dt[] = '`' . $key . '` = \'' . $val . '\''; 
        }
        $db->query("UPDATE `".$prefix."top_comments` SET " . implode(', ', $dt) . " WHERE `id_youtube` = '" . $request->response['top_comment_id'] . "' ");
    }
}else{echo'false';}



?>
