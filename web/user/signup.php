<?php 
        ini_set('error_reporting', E_ALL);
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
	require (dirname(__FILE__).'/../sys/db_user.php');

    if (isset($_SESSION['logged_user']) ){
        header("Location: /");
    }
	
	$data = $_POST;

	function captcha_show(){
		$questions = array(
			1 => 'Столица России',
			2 => 'Столица США',
			3 => '2 + 3',
			4 => '15 + 14',
			5 => '45 - 10',
			6 => '33 - 3'
		);
		$num = mt_rand( 1, count($questions) );
		$_SESSION['captcha'] = $num;
		echo $questions[$num];
	}

	//если кликнули на button
	if ( isset($data['do_signup']) )
	{
    // проверка формы на пустоту полей
		$errors = array();
		if ( trim($data['login']) == '' )
		{
			$errors[] = 'Введите логин';
		}

		if ( trim($data['email']) == '' )
		{
			$errors[] = 'Введите Email';
		}

		if ( $data['password'] == '' )
		{
			$errors[] = 'Введите пароль';
		}

		if ( $data['password_2'] != $data['password'] )
		{
			$errors[] = 'Повторный пароль введен не верно!';
		}

		//проверка на существование одинакового логина
		if ( R::count($mysql_conf['table_users'], "login = ?", array($data['login'])) > 0)
		{
			$errors[] = 'Пользователь с таким логином уже существует!';
		}
    
    //проверка на существование одинакового email
		if ( R::count($mysql_conf['table_users'], "email = ?", array($data['email'])) > 0)
		{
			$errors[] = 'Пользователь с таким Email уже существует!';
		}

		//проверка капчи
		$answers = array(
			1 => 'москва',
			2 => 'вашингтон',
			3 => '5',
			4 => '29',
			5 => '35',
			6 => '30'
		);
		if ( $_SESSION['captcha'] != array_search( mb_strtolower($_POST['captcha']), $answers ) )
		{
			$errors[] = 'Ответ на вопрос указан не верно!';
		}


		if ( empty($errors) )
		{
			//ошибок нет, теперь регистрируем
			$user = R::dispense($mysql_conf['table_users']);
			$user->login = $data['login'];
			$user->email = $data['email'];
			$user->sessionid = generate_code(10);
			$user->datareg = date('Y-m-d H:i:s');
			$user->ip = $_SERVER['REMOTE_ADDR'];
			$user->token = '';
			$user->password = password_hash($data['password'], PASSWORD_DEFAULT); //пароль нельзя хранить в открытом виде, мы его шифруем при помощи функции password_hash для php > 5.6
			R::store($user);
			
            $_SESSION['logged_user'] = array(
                'login' => $user->login,
                'id' => $user->id,
                'sessionid' => $user->sessionid,
                'email' => $user->email,
                'access' => $user->access,
                'datareg' => $user->datareg,
                'nitification' => '0',
                'ip' => $user->ip,
                'token' => '',
                'channel' => $user->channel,
                'read_internal_message' => 0,
                'total_internal_message' => 1,
            );
            setcookie ("nitification", 0,time()+3600, "/");
			$success = 'Вы успешно зарегистрированы!';
			header("Location: /");
		}

	}

?>
<!doctype html>
<html>
<head>
	<link rel="shortcut icon" href="icons/favicon.ico" type="image/x-icon">
	<title>Регистрация</title>
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
.form-signin input{
    border-radius:0;
    margin-bottom: -1px;
}

.form-signin input[name="password_2"]{
    border-radius:0;
    margin-bottom: 4px;
}

.form-signin input[name="login"],
.form-signin input[disabled="disabled"]{
  margin-bottom: -1px;
  border-radius:.25rem;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[name="captcha"],
.form-signin input[name="password_2"]{
  margin-bottom: 10px;
  border-radius:.25rem;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
.container{
    height: 100%;
}

</style>
<?require_once (dirname(__FILE__).'/../template/metrica.php');?>
</head>
<body class="text-center">
    <main role="main" class="container">
       
       
        <?if (!empty($errors) ){?>
        <div class="alert alert-danger fade show"><strong><?=array_shift($errors)?></strong>  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>  </button></div>
        <?}?>
        <?if (!empty($success) ){?>
        <div class="alert alert-success fade show"><strong><?=$success?></strong>  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>  </button></div>
        <?}?>

  
        <form class="form-signin"  method="POST">

            <img class="mb-4" src="/images/photo.jpg" alt="" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal">Please register</h1>
            
            <label for="inputlogin" class="sr-only">Login</label>
            
            <input type="text" name="login"  value="<?php echo @$data['login']; ?>" id="inputlogin" class="form-control" placeholder="Login" required autofocus>
            
            <label for="inputemail" class="sr-only">Email</label>
            
            <input type="text" name="email"  value="<?php echo @$data['email']; ?>" id="inputemail" class="form-control" placeholder="Email" required autofocus>  
            
            <label for="inputPassword" class="sr-only">Password</label>
            
            <input type="password" value="<?php echo @$data['password']; ?>" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
            
            <label for="inputPassword2" class="sr-only">Repeat password</label>
            
            <input type="password" value="<?php echo @$data['password_2']; ?>" name="password_2" id="inputPassword2" class="form-control" placeholder="Repeat password" required>
            
            <input type="text" disabled="disabled" value="<?php captcha_show(); ?>"  class="form-control">  
            
            <label for="inputcaptcha" class="sr-only">Captcha</label>
            
            <input type="text" name="captcha" id="inputcaptcha" class="form-control" placeholder="captcha" required>  

            <button class="btn btn-lg btn-primary btn-block" name="do_signup" type="submit">Registration</button>
            <a href="/user/login.php" class="btn btn-lg btn-secondary btn-block">Sign in</a>
            
            <p class="mt-5 mb-3 text-muted">&copy; 2019</p>
        </form>

    </main>
</body>
</body>
</html>
