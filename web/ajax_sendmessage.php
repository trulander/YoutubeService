<?
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
        

if(isset($_POST['send']) && $_POST['comment'] != ''){

    $ajax = true;//для отключения оптимизации вывода этого скрипта
    require_once (dirname(__FILE__).'/sys/core.php');
    //require_once (dirname(__FILE__).'/request/save_token.php');
    //print_r($_SESSION['logged_user']);

    $client = getClient($_SESSION['logged_user']['token']);
    if($client !='access denied'){
        
        
        if($prefix == ''){
            $prefix = 'eliseev_';
        }

        $request = new request($prefix);
        $request->savetocen(json_encode($client->getAccessToken()));

        $_SESSION['logged_user']['token'] = json_encode($client->getAccessToken());

        
        $service = new Google_Service_YouTube($client);
        $comment = new Google_Service_YouTube_Comment();
        
        $commentSnippet = new Google_Service_YouTube_CommentSnippet();
        $commentSnippet->setParentId($request->topcomment['id_youtube']);
        $commentSnippet->setTextOriginal($_POST['comment']);
        $comment->setSnippet($commentSnippet);
        
        $response = $service->comments->insert('snippet', $comment);
        
   
        echo json_encode(array('result' => $response['id'],'id_parent' => $request->topcomment['id_youtube']));
    }else{
        echo json_encode(array('result' => 'access denied'));
    }
    
}else{
    echo 'errrorishe';
}

?>
