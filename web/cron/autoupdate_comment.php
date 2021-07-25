<?
$path_parts = pathinfo($_SERVER['SCRIPT_FILENAME']); // определяем директорию скрипта
chdir($path_parts['dirname']); // задаем директорию выполнение скрипта

require_once (dirname(__FILE__).'/../sys/request.php');
require_once (dirname(__FILE__).'/../sys/google_api.php');
$prefix = 'eliseev_';
$request = new request($prefix);
$video_id = '';


if($ext = $db->query("SELECT `id_youtube` FROM `".$prefix."videos` ORDER BY date DESC LIMIT 1")->fetch_assoc()){
    $video_id = $ext['id_youtube'];    
}
    
//получаем топовый комментарий с видео и обновляем по нему информацию

echo $video_id;

if ($ext = $db->query("SELECT `id_youtube` FROM `".$prefix."top_comments` ORDER BY update_date DESC LIMIT 1")->fetch_assoc()){
    //print_r($ext['id_youtube']);
    $top_comment_id = $ext['id_youtube'];
}


//Запрашиваем ответы у последнего топового комментария
//require_once (dirname(__FILE__).'/../request/list_comments.php');


    $request->list_comments($top_comment_id,maxResults_comments);
    //print_r($request->response);

$request->autors_in_list = array();




//формируем массив пользователей в текущем наборе комментариев
foreach ($request->response['items'] as $item) {
    $count_message = (isset($request->autors_in_list[$item['snippet']['authorChannelId']['value']]['count_message']))?$request->autors_in_list[$item['snippet']['authorChannelId']['value']]['count_message']:0;
    
	$request->autors_in_list[$item['snippet']['authorChannelId']['value']] = array(
        'user_id_youtube' => $item['snippet']['authorChannelId']['value'],
        'username' => $item['snippet']['authorDisplayName'],
        'avatar_url' => $item['snippet']['authorProfileImageUrl'],
        'count_message' => $count_message + 1
    );
}

//print_r($request->autors_in_list);
foreach($request->autors_in_list as $key => $item){
    if (!$ext = $db->query("SELECT * FROM `".$prefix."users` WHERE `user_id_youtube` = '" . $key . "'")->fetch_assoc()){
        //заносим новых пользователей в бд
        $db->query('INSERT INTO `'.$prefix.'users` SET ?As', array("user_id_youtube" => $key, "username" => $item['username'],"avatar_url" => $item['avatar_url']));
    }else{
        //Обновляем старых
        $db->query("UPDATE `".$prefix."users` SET ?As WHERE `user_id_youtube` = '" . $key . "'", array("username" => $item['username'],"avatar_url" => $item['avatar_url']));
    }
}

//Записываем новые комментарии
foreach (array_reverse($request->response['items']) as $key => $item) {

    if (!$ext = $db->query("SELECT * FROM `".$prefix."comments` WHERE `id_youtube` = '" . $item['id'] . "'")->fetch_assoc()){
        $db->query('INSERT INTO `'.$prefix.'comments` SET ?As', array("id_youtube" => $item['id'], "preply_to_comment_id" => $item['snippet']['parentId'],"comment" => $item['snippet']['textOriginal'],"date" => date("Y-m-d H:i:s", strtotime($item['snippet']['publishedAt'])),"user_id" => $item['snippet']['authorChannelId']['value'],"id_video" => $video_id));
        
        $db->query("UPDATE `".$prefix."users` SET `count_message` = count_message + 1 WHERE `user_id_youtube` = '" . $item['snippet']['authorChannelId']['value'] . "' ");
    }
}



?>
