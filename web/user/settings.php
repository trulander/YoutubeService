<?php 
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    
    require_once (dirname(__FILE__).'/../../vendor/autoload.php');
	require (dirname(__FILE__).'/../sys/db_user.php');
	
    if (!isset($_SESSION['logged_user']) ){
        header("Location: /");
    }
    
	$data = $_POST;
	$success = '';

	
	if ( isset($data['change_eliseev']) )
	{
		$user = R::findOne($mysql_conf['table_users'], 'id = ?', array($_SESSION['logged_user']['id']));
		if ( $user )
		{
            $user->channel = $eliseev_prefix;
            $id = R::store( $user );
            $_SESSION['logged_user'] = array(
                'login' => $user->login,
                'id' => $user->id,
                'sessionid' => $user->sessionid,
                'email' => $user->email,
                'access' => $user->access,
                'datareg' => $user->datareg,
                'nitification' => $user->nitification,
                'ip' => $user->ip,
                'token' => $user->token,
                'channel' => $user->channel,
                'read_internal_message' => $user->read_internal_message,
                'total_internal_message' => $_SESSION['logged_user']['total_internal_message'],
            );
            header("Location: /");
            exit();
		}else{
			$errors[] = 'Какаято ошибка, хз кароч!';
		}
	}
	
	if ( isset($data['change_simon']) )
	{
		$user = R::findOne($mysql_conf['table_users'], 'id = ?', array($_SESSION['logged_user']['id']));
		if ( $user )
		{
            $user->channel = $simon_prefix;
            $id = R::store( $user );
            $_SESSION['logged_user'] = array(
                'login' => $user->login,
                'id' => $user->id,
                'sessionid' => $user->sessionid,
                'email' => $user->email,
                'access' => $user->access,
                'datareg' => $user->datareg,
                'nitification' => $user->nitification,
                'ip' => $user->ip,
                'token' => $user->token,
                'channel' => $user->channel,
                'read_internal_message' => $user->read_internal_message,
                'total_internal_message' => $_SESSION['logged_user']['total_internal_message'],                
            );
            header("Location: /");
            exit();
		}else{
			$errors[] = 'Какаято ошибка, хз кароч!';
		}
	}		
	
	if ( isset($data['do_login']) )
	{
		$user = R::findOne($mysql_conf['table_users'], 'id = ?', array($_SESSION['logged_user']['id']));
		if ( $user )
		{
            $user->nitification = $data['nitification'];
            $id = R::store( $user );
            $_SESSION['logged_user'] = array(
                'login' => $user->login,
                'id' => $user->id,
                'sessionid' => $user->sessionid,
                'email' => $user->email,
                'access' => $user->access,
                'datareg' => $user->datareg,
                'nitification' => $user->nitification,
                'ip' => $user->ip,
                'token' => $user->token,
                'channel' => $user->channel,
                'read_internal_message' => $user->read_internal_message,
                'total_internal_message' => $_SESSION['logged_user']['total_internal_message'],                
            );
            if(!isset($_COOKIE["nitification"]) || $_COOKIE["nitification"] != $user->nitification){
                setcookie ("nitification", $user->nitification, time()+3600, "/");
            }
            $success = 'Настройки сохранены.';
		}else{
			$errors[] = 'Какаято ошибка, хз кароч!';
		}
	}

	if ( isset($data['do_authCode']) )
	{
        if(isset($data['authCode']) && $data['authCode'] != ''){

            $token = getAccesYoutube($data['authCode']);
            if($token != 'error'){
                $user = R::findOne($mysql_conf['table_users'], 'id = ?', array($_SESSION['logged_user']['id']));
                if ( $user )
                {
                    $user->token = $token;
                    $id = R::store( $user );
                    $_SESSION['logged_user'] = array(
                        'login' => $user->login,
                        'id' => $user->id,
                        'sessionid' => $user->sessionid,
                        'email' => $user->email,
                        'access' => $user->access,
                        'datareg' => $user->datareg,
                        'nitification' => $user->nitification,
                        'ip' => $user->ip,
                        'token' => $user->token,
                        'channel' => $user->channel,
                        'read_internal_message' => $user->read_internal_message,
                        'total_internal_message' => $_SESSION['logged_user']['total_internal_message'],                        
                    );
                    $success = 'Доступ получен.';
                }else{
                    $errors[] = 'Какаято ошибка, хз кароч!';
                }
            }else{
                $errors[] = 'Ошибка, возможно код введен неверно.';
            }
        }
	}
?>
<!doctype html>
<html>
<head>
	<link rel="shortcut icon" href="icons/favicon.ico" type="image/x-icon">
	<title>Настройки</title>
    <link rel="stylesheet" type="text/css" href="/css/view/ucompress.css" />	
	<script type="text/javascript" src="/js/view/ucompress.js"></script>
<style>


.btn-block{
    max-width: 391px;
    margin: auto;
}
</style>

<?if($_SESSION['logged_user']['nitification'] != '0'){?>
    <script>
        $(document).ready(function(){
            notify(); 
            $("#testnotification").click(function() {
                notify('Тестовое уведомление', {
                    body: 'Если ты видишь это уведомление, то все разрешения получены.',
                    onclick: function(e) {},
                    onclose: function(e) {},
                    ondenied: function(e) {}
                });
            });        
        });
    </script>
<?}?>
<?require_once (dirname(__FILE__).'/../template/metrica.php');?>
</head>
<body>
<?require_once (dirname(__FILE__).'/../template/top_menu.php');?>
    <main role="main" class="container text-center">
    
        <?if ( ! empty($errors) ){?>
        <div class="alert alert-danger fade show"><strong><?=array_shift($errors)?></strong>  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>  </button></div>
        <?}?>
        <?if (!empty($success) ){?>
        <div class="alert alert-success fade show"><strong><?=$success?></strong>  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>  </button></div>
        <?}?>       
        
        <form class="form-signin"  method="POST">

            <img class="mb-4" src="/images/photo.jpg" alt="" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal">Настройки аккаунта</h1>
            <h2 class="h3 mb-3 font-weight-normal">Системные уведомления</h2>
            <p style="text-align: left;">
                Новая фишка, использовать системные уведомления для отображения комментариев.<br> Комментарии отображаются уведомлениями не в браузере, но для их работы должна быть открыта вкладка с чатом.<br> Не все браузеры это поддерживают, для получения таких уведомлений, браузер должен запросить разрешение на их отправку, еслир разрешения не будет, уведомления не будут отображаться.
            </p>
            <select id="nitification" name="nitification">
                <option value="0" <?=($_SESSION['logged_user']['nitification'] == '0')?'selected':''?>>Отключено</option>
                <option value="1" <?=($_SESSION['logged_user']['nitification'] == '1')?'selected':''?>>Уведомлять только о комментариях от важных пользователей</option>
                <option value="2" <?=($_SESSION['logged_user']['nitification'] == '2')?'selected':''?>>Уведомлять о всех комментариях.</option>
            </select>  

            <br><br>
            <button class="btn btn-lg btn-primary btn-block" name="do_login" type="submit">Применить</button><br>
        </form>
        
        <button class="btn btn-lg btn-primary btn-block" id="testnotification" type="button">Тест уведомлений</button>

        
<?if($_SESSION['logged_user']['access'] == '10'){?>

    
        <form class="form-signin"  method="POST">

            <h2 class="h3 mb-3 font-weight-normal">Доступ к youtube, для постинга сообщений из сервиса.</h2>
            <p style="text-align: left;">
                Для постинга сообщений из сервиса, нужно запросить разрешения на постинг сообщений у youtube через ваш аккаунт.<br>
                Для выполнения запроса, перейдите по <a target="_blank" href="<?=getAccesYoutube('');?>">ссылке</a>.<br>
                После получения кода авторизации введите его в поле ниже и нажмите "Применить".
            </p>
            <?if($_SESSION['logged_user']['token'] != ''){?><p>Вы уже получали доступ, если что то пошло не так, можно запросить его заного.</p><?}?>
            <input type="text" id="authCode" name="authCode" placeholder="access key">

            <br><br>
            <button class="btn btn-lg btn-primary btn-block" name="do_authCode" type="submit">Применить</button><br>
        </form>    
        
<?}?>        
        <p class="mt-5 mb-3 text-muted">&copy; 2019</p>
    </main>
</body>
</html>
