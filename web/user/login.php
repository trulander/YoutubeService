<?php 
	require (dirname(__FILE__).'/../sys/db_user.php');
    if (isset($_SESSION['logged_user']) ){
        header("Location: /");
    }
    
	$data = $_POST;
	if ( isset($data['do_login']) )
	{
		$user = R::findOne($mysql_conf['table_users'], 'login = ?', array($data['login']));
		if ( $user )
		{
			//логин существует
			if ( password_verify($data['password'], $user->password) )
			{
				//если пароль совпадает, то нужно авторизовать пользователя
				
				//получаем общее число сообщений в чате для этого пользователя
				if($user->access <= 2){
                    $count_internal_message = R::count($mysql_conf['table_internalchat'], "STR_TO_DATE(`date`, '%Y-%m-%d  %H:%i') > STR_TO_DATE('" .date("Y-m-d  H:i", strtotime($user->datareg)). "', '%Y-%m-%d %H:%i') OR `id` = '13'");
                }else{
                    $count_internal_message = R::count($mysql_conf['table_internalchat']);
                }
				
                $user->sessionid = generate_code(10);
                $user->datalastvisits = date('Y-m-d H:i:s');
                $user->contvisite = $user->contvisite+1;
                $user->ip = $_SERVER['REMOTE_ADDR'];
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
                    'total_internal_message' => $count_internal_message,
				);
                if(!isset($_COOKIE["nitification"]) || $_COOKIE["nitification"] != $user->nitification){
                    setcookie ("nitification", $user->nitification, time()+3600, "/");
                }
                if(isset($_POST['remember-me']) && $_POST['remember-me'] == '1'){//для сессии, если отмечен чекбокс запомнить меня, то продлеваем сессию на сутки
                      $lifetime=60*60*24*3;//3 day
                      setcookie(session_name(),session_id(),time()+$lifetime,"/");
                }
				//print_r($_SESSION['logged_user']);
				//print_r();

				header("Location: /");
			}else
			{
				$errors[] = 'Неверно введен пароль!';
			}

		}else
		{
			$errors[] = 'Пользователь с таким логином не найден!';
		}
	}

?>
<!doctype html>
<html>
<head>
	<link rel="shortcut icon" href="icons/favicon.ico" type="image/x-icon">
	<title>Авторизация</title>
<?/*
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <script src="/js/bootstrap/bootstrap.min.js"></script>	
	<script src="/js/offcanvas.js"></script>
	<link rel="stylesheet" type="text/css" href="/css/offcanvas.css" />	
	<link rel="stylesheet" type="text/css" href="/css/newstyle.css" />
*/?>
    <link rel="stylesheet" type="text/css" href="/css/user/ucompress.css" />
<style>
html,
body {
  height: 100%;
}

body {
  display: -ms-flexbox;
  display: flex;
  -ms-flex-align: center;
  align-items: center;
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #f5f5f5;
}

.form-signin {
  width: 100%;
  max-width: 330px;
  padding: 15px;
  margin: auto;
}
.form-signin .checkbox {
  font-weight: 400;
}
.form-signin .form-control {
  position: relative;
  box-sizing: border-box;
  height: auto;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="text"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}

</style>
<?require_once (dirname(__FILE__).'/../template/metrica.php');?>
</head>
<body class="text-center">
    <main role="main" class="container">
    
        <?if ( ! empty($errors) ){?>
        <div class="alert alert-danger fade show"><strong><?=array_shift($errors)?></strong>  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>  </button></div>
        <?}?>
        
        <form class="form-signin"  method="POST">

        <img class="mb-4" src="/images/photo.jpg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
        <label for="inputlogin" class="sr-only">Login</label>
        
        <input type="text" name="login" id="inputlogin" class="form-control" placeholder="Login" required autofocus>
        
        <label for="inputPassword" class="sr-only">Password</label>
        
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
        
        <div class="checkbox mb-3">
            <label>
            <input type="checkbox" name="remember-me" value="1" checked> Remember me
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" name="do_login" type="submit">Sign in</button>
        <a href="/user/signup.php" class="btn btn-lg btn-secondary btn-block">Registration</a>
        <p class="mt-5 mb-3 text-muted">&copy; 2019</p>
        </form>

    </main>
</body>
</html>
