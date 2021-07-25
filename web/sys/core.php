<?
	require_once (dirname(__FILE__).'/config.php');//Должен быть самым первым
    session_start();    
    if(!isset($ajax) && $is_compress && $_SESSION['logged_user']['access'] != '10'){
        require_once (dirname(__FILE__).'/../../class/optimize/Optimize.php');
        ob_start(array('Optimize', 'html'));
    }
    
    $error = false;//Переменная задающая ошибку при получении данных из бд, будем отдавать 404

   

    
    if (!isset($_SESSION['logged_user']) ){
        header("Location: /user/login.php");
        exit();
    }
    
    if($_SESSION['logged_user']['access'] == '10'){
        ini_set('error_reporting', E_ALL);
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
    }    
    
	require_once (dirname(__FILE__).'/../../vendor/autoload.php');
	require_once (dirname(__FILE__).'/db.php');
	
	//use Krugozor\Database\Mysql\Mysql as Mysql;

	require_once (dirname(__FILE__).'/request.php');
	require_once (dirname(__FILE__).'/functions.php');

	//print_r((array) $_SESSION['logged_user']);
	
    //запрашиваем инфу по каждому юзеру из бд
    if ($user = $db->query("SELECT * FROM `users_reg` WHERE `id` = ".$_SESSION['logged_user']['id'])->fetch_assoc()){
        if ($_SESSION['logged_user']['sessionid'] != $user['sessionid']){
            unset($_SESSION['logged_user']);
            header("Location: /user/login.php");
            exit();
        }   
        
        $_SESSION['logged_user'] = array(
            'login' => $user['login'],
            'id' => $user['id'],
            'sessionid' => $user['sessionid'],
            'email' => $user['email'],
            'access' => $user['access'],
            'datareg' => $user['datareg'],
            'nitification' => $user['nitification'],
            'ip' => $user['ip'],
            'token' => $user['token'],
            'channel' => $user['channel'],
            'read_internal_message' => $user['read_internal_message'],
            'total_internal_message' => $_SESSION['logged_user']['total_internal_message'],
        );
        if(!isset($_COOKIE["nitification"]) || $_COOKIE["nitification"] != $user['nitification']){
            setcookie ("nitification", $user['nitification'], time()+3600, "/");
        }
        $prefix = $_SESSION['logged_user']['channel'];
        
    }else{
        unset($_SESSION['logged_user']);
        header("Location: /user/login.php");
        exit();
    }
    
    
    
 //$this->db->query("UPDATE `usergroups` SET " . implode(', ', $value) . " WHERE `id` = '" . $this->id . "' ");

?> 
