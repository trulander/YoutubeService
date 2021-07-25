<?
//require_once (dirname(__FILE__).'/core.php');

use Krugozor\Database\Mysql\Mysql as Mysql;
// Соединение с СУБД и получение объекта-"обертки" над "родным" mysqli
$GLOBALS['db'] = Mysql::create($mysql_conf['host'], $mysql_conf['username'], $mysql_conf['password'])
      // Выбор базы данных
      ->setDatabaseName($mysql_conf['database'])
      // Выбор кодировки
      ->setCharset("utf8mb4");//кодировка с поддержкой эмодзи иконок


//print_r($db);
?>
