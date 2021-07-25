<?

//получаем свежее видео
if ($video = $db->query("SELECT * FROM `eliseev_videos` ORDER BY date DESC LIMIT 1")->fetch_assoc()){
    $video_id = $video['id_youtube'];//Запоминаем идентификатор старого видео в будущем будем с ним сравнивать то что есть в базе посвежее
    //print_r($video);
    
    //получаем топ коммент
    if(!isset($list_comments))$list_comments = array();
    
    if(!isset($autors_in_list))$autors_in_list = array();

    if ($topcomment = $db->query("SELECT * FROM `eliseev_top_comments` WHERE `id_video` = '?s' ORDER BY update_date DESC LIMIT 1",$video['id_youtube'])->fetch_assoc()){
        $autors_in_list[$topcomment['user_id']] = $topcomment['user_id'];
    }    

    //print_r($topcomment);
    if(isset($last_time_comment)){
        $where = " AND STR_TO_DATE(`date`, '%Y-%m-%d  %H:%i:%s') > STR_TO_DATE('" .date("Y-m-d  H:i:s", strtotime($last_time_comment)). "', '%Y-%m-%d %H:%i:%s')";
    }else{
        $where = '';
    }


    if ($list_comments = $db->query("SELECT * FROM `eliseev_comments` WHERE `preply_to_comment_id` = '?s'".$where." ORDER BY date DESC LIMIT 350",$topcomment['id_youtube'])->fetch_assoc_array()){
        //собираем уникальных пользователей в чате
        foreach($list_comments as $val){
            $autors_in_list[$val['user_id']] = $val['user_id'];
        }
    }    
    //запрашиваем инфу по каждому юзеру из бд
    if ($list_users = $db->query("SELECT * FROM `eliseev_users` WHERE `user_id_youtube` IN (?as)", $autors_in_list)->fetch_assoc_array()){
        foreach($list_users as $user){
            $listusers[$user['user_id_youtube']] = $user;
        }
    }    
}

?>
