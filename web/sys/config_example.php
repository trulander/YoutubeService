<?

//ini_set('error_reporting', E_ALL);

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);

//ini_set('display_errors', 0);
//ini_set('display_startup_errors', 0);
$is_compress = true;//сжимать исходный код html до 1 строки
$is_allow_feedback = true;//показать кнопку обратной связи в меню
$domainname = 'youtube.ru';//domain.zone


/*ключи для канала елисея*/
$api_key = '';//запрашиваем список комментариев в чате //нагрузка по квоте 100%
$api_key2 = '';//запрашиваем новый чат после 14 часов //нагрузка по квоте 55%
$api_key3 = '';//запрашиваем новые видео до 14 часов //нагрузка по квоте 100%
$api_key4 = '';//запрашиваю новое видео после 14 часов //нагрузка по квоте хз
$api_key5 = '';//для запроса нового чата до 14 часов //нагрузка по квоте 1%



/*ключи для канала саймона*/
$api_key6 = '';//video до 14часов (10:00 - 18:00) норм
$api_key7 = '';//top_comment
$api_key8 = '';//comment
$api_key9 = '';//video после 14 часов (18:00 - 02:00) норм (02:00 - 04:00)лимит


define('simon_channelId','UCVOWQBowdCy_ILKjW58zemQ');
//define('simon_playlistId','LLSdSBG3MRqhiZv4S1wO39SQ');


define('eliseev_channelId','UCSdSBG3MRqhiZv4S1wO39SQ');
define('eliseev_playlistId','LLSdSBG3MRqhiZv4S1wO39SQ');

define('maxResults_comments',30);
define('maxResults_top_comment',1);
define('maxResults_list_video',1);

$important_autors = array(//список авторов кого будем подсвечивать в списке комментарием и от кого можно обновлять топ
	'UCSdSBG3MRqhiZv4S1wO39SQ'=>10,//Сергей Елисеев
	'UCVOWQBowdCy_ILKjW58zemQ'=>10//Саймонов биржевик
);


$eliseev_prefix = 'eliseev_';
$simon_prefix = 'simon_';

$mysql_conf = array(
    'driver'			=> 'mysqli',
    'host'      		=> 'localhost',
    'port'    			=> '3306',
    'database'  		=> '',
    'username'      	=> '',
    'password'  	    => '',
    'charset'   		=> 'utf8',
    'collation' 		=> 'utf8_unicode_ci',
    'prefix'    		=> '',
    'table_users'       => 'users_reg',
    'table_internalchat'       => 'internal_chat',
);

?> 
