<?
function in_array_r($needle, $haystack) { 
    foreach ($haystack as $key => $item) {
        if ($key == $needle) {
            return true;
        }
    }
    return false;
}
//генератор случайных символов
function generate_code($length){
    $num = range(0, 9);
    $alf = range('a', 'z');
    $_alf = range('A', 'Z');
    $symbols = array_merge($num, $alf, $_alf);
    shuffle($symbols);
    $code_array = array_slice($symbols, 0, (int)$length);
    $code = implode("", $code_array);
    return $code;
}
//echo generate_code(10);






//Запрос разрешения к доступу гугл аккаунта на youtube
function getAccesYoutube($authCode)
{


    $client = new Google_Client();
    $client->setApplicationName('Request access for post comments on youtube');
    $client->setScopes([
        'https://www.googleapis.com/auth/youtube.force-ssl',
    ]);

    $client->setAuthConfig(dirname(__FILE__).'/../sys/credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');
    
    if($authCode == ''){//если не передаем в функцию код авторизации, то выводим ссылку на его получение
        $authUrl = $client->createAuthUrl();
        return $authUrl;
    }else{
            $authCode = trim($authCode);
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            if (array_key_exists('error', $accessToken)) {
               return 'error';
            }else{
                $client->setAccessToken($accessToken);
                return json_encode($client->getAccessToken());
            }
    }
    
}

//запрашиваем объект с доступом для постинга сообщений
function getClient($token)
{
    $client = new Google_Client();
    $client->setApplicationName('Request access for post comments on youtube');
    $client->setScopes([
        'https://www.googleapis.com/auth/youtube.force-ssl',
    ]);

    $client->setAuthConfig(dirname(__FILE__).'/../sys/credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    $accessToken = json_decode($token, true);
    $client->setAccessToken($accessToken);


    // If there is no previous token or it's expired.
    if ($client->isAccessTokenExpired()) {
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            return $client;
        }else{
            return 'access denied';
        }
    }
    return $client;
}

?> 
