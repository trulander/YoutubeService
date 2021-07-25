<?
require_once (dirname(__FILE__).'/config.php');
if(!isset($ajax) && $is_compress){
    require_once (dirname(__FILE__).'/../../class/optimize/Optimize.php');
    ob_start(array('Optimize', 'html'));
}

require_once (dirname(__FILE__).'/../../class/rb.php');
require_once (dirname(__FILE__).'/functions.php');
R::setup( 'mysql:host='.$mysql_conf['host'].';dbname='.$mysql_conf['database'],$mysql_conf['username'], $mysql_conf['password'] ); 

if ( !R::testconnection() )
{
		exit ('Нет соединения с базой данных');
}

session_start();
