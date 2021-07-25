<?
$path_parts = pathinfo($_SERVER['SCRIPT_FILENAME']); // определяем директорию скрипта
chdir($path_parts['dirname']); // задаем директорию выполнение скрипта




if(date("H") < 14){
    $change_apikey = 3;
}else{
    $change_apikey = 4;
}



//require_once (dirname(__FILE__).'/../../vendor/autoload.php');
//require_once (dirname(__FILE__).'/../sys/config.php');
//require_once (dirname(__FILE__).'/../sys/db.php');

//use Krugozor\Database\Mysql\Mysql as Mysql;

require_once (dirname(__FILE__).'/../sys/request.php');
//require_once (dirname(__FILE__).'/../sys/functions.php');

require_once (dirname(__FILE__).'/../sys/google_api.php');
$prefix = 'eliseev_';
$request = new request($prefix);
$video_id = '';


//проверяем наличие новых видео и записываем их
	

    $request->list_video(eliseev_channelId,maxResults_list_video);
    //$request->list_video_playlist(eliseev_playlistId,maxResults_list_video);//загрузка списка видео через плейлист
//print_r($request->response);


//require_once (dirname(__FILE__).'/../request/list_video.php');//ищем свежее видео по стандартному списку видео с сортировкой по дате
//require_once (dirname(__FILE__).'/../request/list_video_like.php');//ищем свежее видео по плейлиску с понравившимися видео. ненадежно, но другой вариант перестал выдавать свежие видео.
foreach(array_reverse($request->list_videos) as $key => $item){
    if (!$ext = $db->query("SELECT * FROM `".$prefix."videos` WHERE `id_youtube` = '" . $key . "'")->fetch_assoc()){
        $db->query('INSERT INTO `'.$prefix.'videos` SET ?As', array("id_youtube" => $key, "title" => $item['title'], "image_url" => $item['url_image'], "description" => $item['description'], "date" => date("Y-m-d H:i:s", strtotime($item['publishedAt']))));
    }
    $video_id = $key;
}
echo $video_id;

?>
