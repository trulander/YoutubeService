<?
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

	require_once (dirname(__FILE__).'/../../vendor/autoload.php');
	require_once (dirname(__FILE__).'/config.php');
	require_once (dirname(__FILE__).'/db.php');
	
	//use Krugozor\Database\Mysql\Mysql as Mysql;

	require_once (dirname(__FILE__).'/functions.php');

	//$change_apikey = 2; - изменит api ключ на резервный второй
	if(isset($change_apikey)){
        switch($change_apikey){
            case 2:
                $api_key = $api_key2;
                break;
            case 3:
                $api_key = $api_key3;
                break;
            case 4:
                $api_key = $api_key4;
                break;
            case 5:
                $api_key = $api_key5;
                break;
            case 6:
                $api_key = $api_key6;
                break;   
            case 7:
                $api_key = $api_key7;
                break;   
            case 8:
                $api_key = $api_key8;
                break;
            case 9:
                $api_key = $api_key9;
                break;                  
        }
	}
	
	$client = new Google_Client();
	$client->setDeveloperKey($api_key);
	$service = new Google_Service_YouTube($client);
?>
