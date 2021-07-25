<?
require_once (dirname(__FILE__).'/../../class/jsmin/jsmin.php');
require_once (dirname(__FILE__).'/../../class/optimize/Optimize.php');

$libs_js = array(
    'user'=> array(
        'jquery' => '/../js/jquery.min.js',
        'bootstrap' => '/../js/bootstrap/bootstrap.min.js',
        'offcanvas' => '/../js/offcanvas.js'
    ),
    'view' => array(
        'jquery' => '/../js/jquery.min.js',
        'js-notify' => '/../js/js-notify/notify.min.js',
        'script' => '/../js/script.js',
        'bundle' => '/../js/tooltip/js/tooltipster.bundle.min.js',
        'bootstrap' => '/../js/bootstrap/bootstrap.min.js',
        'offcanvas' => '/../js/offcanvas.js',
        'jquery.cookie' => '/../js/js.cookie.js',
    ),
);


$libs_css = array(
    'user'=> array(
        'bootstrap' => '/../css/bootstrap/bootstrap.min.css',
        'offcanvas' => '/../css/offcanvas.css',
        'newstyle' => '/../css/newstyle.css'
    ),
    'view' => array(
        'tooltipster.bundle' => '/../js/tooltip/css/tooltipster.bundle.min.css',
        'bootstrap' => '/../css/bootstrap/bootstrap.min.css',
        'offcanvas' => '/../css/offcanvas.css',
        'newstyle' => '/../css/newstyle.css'
    ),
);


/* копируем новые файлы*/
foreach($libs_js as $names => $urls) {
    foreach($urls as $name => $url) {
        echo __DIR__ .$url.'<br>';
        @mkdir(__DIR__."/../js/$names/", 0755);
        copy(__DIR__ .$url, __DIR__."/../js/$names/$name.js");    
    
        //file_put_contents(__DIR__ . "/../js/$names/$name.js", file_get_contents($url));
    }
}
/* обжимаем и сохраняем отдельно и общую сжатую версию*/
foreach($libs_js as $names => $urls) {
 file_put_contents(__DIR__."/../js/$names/ucompress.js",'');
    foreach($urls as $name => $url) {
        echo "Testing $name ";

        $jsmin_c   = shell_exec(__DIR__ . "/jsmin < ".__DIR__."/../js/$names/$name.js");
        $jsmin_php = JSMin::minify(file_get_contents(__DIR__ . "/../js/$names/$name.js"));

        file_put_contents(__DIR__."/../js/$names/$name.compress.js", preg_replace('/[\r\n]/sxSX', "", $jsmin_php));
        file_put_contents(__DIR__."/../js/$names/ucompress.js", file_get_contents(__DIR__."/../js/$names/ucompress.js")."".preg_replace('/[\r\n]/sxSX', "", $jsmin_php));
        
        if (preg_replace('/[\r\n]/sxSX', "", $jsmin_c) === preg_replace('/[\r\n]/sxSX', "", $jsmin_php)) {
            echo "[PASS]<br>";
        } else {
            echo "[FAIL]<br>";
            echo "==> Output differs between jsmin.c and jsmin.php.<br>";
        }
    }
}




/* копируем новые файлы*/
foreach($libs_css as $names => $urls) {
    foreach($urls as $name => $url) {
        echo __DIR__ .$url.'<br>';
        @mkdir(__DIR__."/../css/$names/", 0755);
        copy(__DIR__ .$url, __DIR__."/../css/$names/$name.css");    
    
        //file_put_contents(__DIR__ . "/../js/$names/$name.js", file_get_contents($url));
    }
}
/* обжимаем и сохраняем отдельно и общую сжатую версию*/
foreach($libs_css as $names => $urls) {
 file_put_contents(__DIR__."/../css/$names/ucompress.css",'');
    foreach($urls as $name => $url) {
        echo "Compress: $name <br>";

        file_put_contents(__DIR__."/../css/$names/$name.compress.css", Optimize::css(file_get_contents(__DIR__ .$url, __DIR__."/../css/$names/$name.css")));
        file_put_contents(__DIR__."/../css/$names/ucompress.css", file_get_contents(__DIR__."/../css/$names/ucompress.css")."".Optimize::css(file_get_contents(__DIR__ .$url, __DIR__."/../css/$names/$name.css")));
        
    }
}


echo "Done.<br>";
?>
