<?

//запрашиваем инфу по каждому юзеру из бд
if ($list_users = $db->query("SELECT * FROM `eliseev_users` ORDER BY count_message DESC LIMIT 250")->fetch_assoc_array()){
    foreach($list_users as $user){
        $listusers[$user['user_id_youtube']] = $user;
    }
}

    
    //print_r($listusers);
    
?>
