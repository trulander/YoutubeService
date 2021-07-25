<?
if(isset($_POST['message-text']) && $_POST['message-text'] != ''){

$comment = htmlspecialchars($_POST['message-text'], ENT_QUOTES);
        $db->query('INSERT INTO `internal_chat` SET ?As', array("comment" => $comment, "user_id" => $_SESSION['logged_user']['id'],"from" => $_SESSION['logged_user']['id']));
        //$db->query("UPDATE `users` SET `count_message` = count_message + 1 WHERE `user_id_youtube` = '" . $item['snippet']['authorChannelId']['value'] . "' ");
        header('Location: https://youtube.kesok.ru/feedback.php');
}

$autors_in_list = array('1'=>'1');
//print_r($topcomment);
if($_SESSION['logged_user']['access'] <= 2){
    $where = "WHERE STR_TO_DATE(`date`, '%Y-%m-%d  %H:%i') > STR_TO_DATE('" .date("Y-m-d  H:i", strtotime($_SESSION['logged_user']['datareg'])). "', '%Y-%m-%d %H:%i') OR `id` = '13'";
}else{
    $where = '';
}
//запрашиваем инфу по каждому юзеру из бд
if ($list_comments = $db->query("SELECT * FROM `internal_chat` ".$where." ORDER BY date DESC LIMIT 250")->fetch_assoc_array()){
        foreach($list_comments as $val){
            $autors_in_list[$val['from']] = $val['from'];
            $autors_in_list[$val['user_id']] = $val['user_id'];
        }
        //запрашиваем инфу по каждому юзеру из бд
        if ($list_users = $db->query("SELECT id,login FROM `users_reg` WHERE `id` IN (?as)", $autors_in_list)->fetch_assoc_array()){
            foreach($list_users as $user){
                $listusers[$user['id']] = $user['login'];
            }
//print_r($listusers);
        }  
}

?>
