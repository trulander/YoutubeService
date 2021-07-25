<?
    if ($topcomment = $db->query("SELECT * FROM `top_comments` ORDER BY update_date DESC LIMIT 1")->fetch_assoc()){
    } 

    function savetocen($db,$save_token){
        $db->query("UPDATE `users_reg` SET `token` = '".$save_token."',`count_send_message` = count_send_message+1 WHERE `id` = '" . $_SESSION['logged_user']['id'] . "' ");
    }
?>
