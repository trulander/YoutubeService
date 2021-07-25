<?
    $list_topcomments = array();
    if ($list_topcomments = $db->query("SELECT * FROM `eliseev_top_comments` WHERE `id_video` = '?s' ORDER BY date DESC LIMIT 15",$video_id)->fetch_assoc_array()){
        //собираем уникальных пользователей в чате
        foreach($list_topcomments as $val){
            $autors_in_list[$val['user_id']] = $val['user_id'];
        }
        //запрашиваем инфу по каждому юзеру из бд
        if ($list_users = $db->query("SELECT * FROM `eliseev_users` WHERE `user_id_youtube` IN (?as)", $autors_in_list)->fetch_assoc_array()){
            foreach($list_users as $user){
                $listusers[$user['user_id_youtube']] = $user;
            }
        }        
    }else{
        //не будем отдавть 404 так как кимментариев к новому видео может еще не оказаться, а доп проверок делать не желательно
        //$error = true;
    }
?>
