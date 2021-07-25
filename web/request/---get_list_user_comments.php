<?
    if ($user = $db->query("SELECT * FROM `eliseev_users` WHERE `user_id_youtube` = '?s'",$user_id)->fetch_assoc()){
        if ($list_comments = $db->query("SELECT * FROM `eliseev_comments` WHERE `user_id` = '?s' ORDER BY date DESC LIMIT 200",$user_id)->fetch_assoc_array()){
        }
    }else{
        $error = true;
    }

    
    
    //print_r($list_comments);
    
?>
