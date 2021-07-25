<?
class request{
    private $db;
    private $last_time_comment;
    public $autors_in_list;
    public $user_id;
    public $preply_to_comment_id;
    public $video_id;
    public $service;
    
    public $list_comments;
    public $listusers;
    public $prefix;
    public $list_users;
    public $topcomment;
    public $user;
    public $list_videos;
    public $list_topcomments;
    public $response;
   
    
   function __construct($prefix) {
        $this->prefix = $prefix;
       
        $this->db = $GLOBALS['db'];
        $this->last_time_comment = isset($GLOBALS['last_time_comment'])?$GLOBALS['last_time_comment']:'';
        
        $this->autors_in_list = isset($GLOBALS['autors_in_list'])?$GLOBALS['autors_in_list']:array();
        $this->user_id = isset($GLOBALS['user_id'])?$GLOBALS['user_id']:'';
        $this->video_id = isset($GLOBALS['video_id'])?$GLOBALS['video_id']:'';
        $this->preply_to_comment_id = isset($GLOBALS['preply_to_comment_id'])?$GLOBALS['preply_to_comment_id']:'';
        
        global $service;
        $this->service = isset($service)?$service:'';
       
       
   }
    
    /*При постинге сообщения в youtube нужно обновлять в базе получаемый токен*/
    public function savetocen($save_token){
        if ($this->topcomment = $this->db->query("SELECT * FROM `".$this->prefix."top_comments` ORDER BY update_date DESC LIMIT 1")->fetch_assoc()){
        } 
        $this->db->query("UPDATE `users_reg` SET `token` = '".$save_token."',`count_send_message` = count_send_message+1 WHERE `id` = '" . $_SESSION['logged_user']['id'] . "' ");
    }
    

    
    /*получаем 1 свежее видео*/
    public function get_videos(){
        if ($video = $this->db->query("SELECT * FROM `".$this->prefix."videos` ORDER BY date DESC LIMIT 1")->fetch_assoc()){
            $this->video_id = $video['id_youtube'];//Запоминаем идентификатор старого видео в будущем будем с ним сравнивать то что есть в базе посвежее
            //print_r($video);
            
            //получаем топ коммент
            if(!isset($this->list_comments))$this->list_comments = array();
            
            if(!isset($this->autors_in_list))$this->autors_in_list = array();
//$video['id_youtube']='007';
            if ($this->topcomment = $this->db->query("SELECT * FROM `".$this->prefix."top_comments` WHERE `id_video` = '?s' ORDER BY update_date DESC LIMIT 1",$video['id_youtube'])->fetch_assoc()){
                $this->autors_in_list[$this->topcomment['user_id']] = $this->topcomment['user_id'];

                //print_r($this->topcomment);
                if(isset($this->last_time_comment)){
                    $where = " AND STR_TO_DATE(`date`, '%Y-%m-%d  %H:%i:%s') > STR_TO_DATE('" .date("Y-m-d  H:i:s", strtotime($this->last_time_comment)). "', '%Y-%m-%d %H:%i:%s')";
                }else{
                    $where = '';
                }


                if ($this->list_comments = $this->db->query("SELECT * FROM `".$this->prefix."comments` WHERE `preply_to_comment_id` = '?s'".$where." ORDER BY date DESC LIMIT 350",$this->topcomment['id_youtube'])->fetch_assoc_array()){
                    //собираем уникальных пользователей в чате
                    foreach($this->list_comments as $val){
                        $this->autors_in_list[$val['user_id']] = $val['user_id'];
                    }
                }
                //запрашиваем инфу по каждому юзеру из бд
                if ($this->list_users = $this->db->query("SELECT * FROM `".$this->prefix."users` WHERE `user_id_youtube` IN (?as)", $this->autors_in_list)->fetch_assoc_array()){
                    foreach($this->list_users as $user){
                        $this->listusers[$user['user_id_youtube']] = $user;
                    }
                }
            }else{
                $this->topcomment = 
                array(
                    'id' => '',
                    'date' => '00:00:00',
                    'id_youtube' => '',
                    'id_video' => $this->video_id,
                    'user_id' => 0,
                    'comment' => 'Все хорошо, ждем комментарии...',
                    'count_reply' => 0,
                    'update_date' => '',
                    );
                $this->list_users = 
                array(
                    '0' => Array
                        (
                            'id' => 0,
                            'user_id_youtube' => '',
                            'username' => ' ',
                            'important' => '',
                            'avatar_url' => '/images/photo.jpg',
                            'count_message' => 0,
                        )
                    );          
                $this->listusers = 
                array(
                    '0' => Array
                        (
                            'id' => 0,
                            'user_id_youtube' => '',
                            'username' => '',
                            'important' => '',
                            'avatar_url' => '/images/photo.jpg',
                            'count_message' => 0,
                        )
                );
            }

        }
    }
    
    
    
    /*получаем 1 свежее видео teeeeeest*/
    public function get_videos1(){
        if ($video = $this->db->query("SELECT * FROM `".$this->prefix."videos` ORDER BY date DESC LIMIT 1")->fetch_assoc()){
            $this->video_id = $video['id_youtube'];//Запоминаем идентификатор старого видео в будущем будем с ним сравнивать то что есть в базе посвежее
            //print_r($video);
            
            //получаем топ коммент
            if(!isset($this->list_comments))$this->list_comments = array();
            
            if(!isset($this->autors_in_list))$this->autors_in_list = array();

            $video['id_youtube']='007';
            
            if ($this->topcomment = $this->db->query("SELECT * FROM `".$this->prefix."top_comments` WHERE `id_video` = '?s' ORDER BY update_date DESC LIMIT 1",$video['id_youtube'])->fetch_assoc()){
                $this->autors_in_list[$this->topcomment['user_id']] = $this->topcomment['user_id'];

                //print_r($this->topcomment);
                if(isset($this->last_time_comment)){
                    $where = " AND STR_TO_DATE(`date`, '%Y-%m-%d  %H:%i:%s') > STR_TO_DATE('" .date("Y-m-d  H:i:s", strtotime($this->last_time_comment)). "', '%Y-%m-%d %H:%i:%s')";
                }else{
                    $where = '';
                }


                if ($this->list_comments = $this->db->query("SELECT * FROM `".$this->prefix."comments` WHERE `preply_to_comment_id` = '?s'".$where." ORDER BY date DESC LIMIT 350",$this->topcomment['id_youtube'])->fetch_assoc_array()){
                    //собираем уникальных пользователей в чате
                    foreach($this->list_comments as $val){
                        $this->autors_in_list[$val['user_id']] = $val['user_id'];
                    }
                }    
                //запрашиваем инфу по каждому юзеру из бд
                if ($this->list_users = $this->db->query("SELECT * FROM `".$this->prefix."users` WHERE `user_id_youtube` IN (?as)", $this->autors_in_list)->fetch_assoc_array()){
                    foreach($this->list_users as $user){
                        $this->listusers[$user['user_id_youtube']] = $user;
                    }
                }    
            }else{
            
                $this->topcomment = 
                array(
                    'id' => '',
                    'date' => '00:00:00',
                    'id_youtube' => '',
                    'id_video' => '',
                    'user_id' => '',
                    'comment' => 'Все хорошо, ждем комментарии...',
                    'count_reply' => 0,
                    'update_date' => '',
                    );
                $this->list_comments = 
                array(
                    '0' => Array
                        (
                            'id' => '', 
                            'id_video' => '',
                            'user_id' => '',
                            'id_youtube' => '',
                            'date' => '00:00:00',
                            'comment' => '   ',
                            'preply_to_comment_id' => '',
                        )                    
                );
                
                
                $this->list_users = 
                array(
                    '0' => Array
                        (
                            'id' => '',
                            'user_id_youtube' => '',
                            'username' => '  ',
                            'important' => '',
                            'avatar_url' => '',
                            'count_message' => 0,
                        )
                    );          
                
                
            }


        }
    }    
    
    
    //запрашиваем инфу по каждому юзеру из бд
    public function get_list_users(){
        if ($this->list_users = $this->db->query("SELECT * FROM `".$this->prefix."users` ORDER BY count_message DESC LIMIT 250")->fetch_assoc_array()){
            foreach($this->list_users as $user){
                $this->listusers[$user['user_id_youtube']] = $user;
            }
        }    
    }
    
    
    ////Запрашиваем список комментариев пользователя
    public function get_list_user_comments(){
        if ($this->user = $this->db->query("SELECT * FROM `".$this->prefix."users` WHERE `user_id_youtube` = '?s'",$this->user_id)->fetch_assoc()){
            if ($this->list_comments = $this->db->query("SELECT * FROM `".$this->prefix."comments` WHERE `user_id` = '?s' ORDER BY date DESC LIMIT 200",$this->user_id)->fetch_assoc_array()){
            }
        }else{
            $GLOGALS['error'] = true;
        }
    }
    
    
    ///Получаем список видео
    public function get_list_videos(){
        $this->list_videos = array();
        if (!$this->list_videos = $this->db->query("SELECT * FROM `".$this->prefix."videos` ORDER BY date DESC LIMIT 10")->fetch_assoc_array()){
            
        }
    }
    
    ////Получаем список чатов под видео
    public function get_top_comments(){
        $this->list_topcomments = array();
        if ($this->list_topcomments = $this->db->query("SELECT * FROM `".$this->prefix."top_comments` WHERE `id_video` = '?s' ORDER BY date DESC LIMIT 15",$this->video_id)->fetch_assoc_array()){
            //собираем уникальных пользователей в чате
            foreach($this->list_topcomments as $val){
                $this->autors_in_list[$val['user_id']] = $val['user_id'];
            }
            //запрашиваем инфу по каждому юзеру из бд
            if ($this->list_users = $this->db->query("SELECT * FROM `".$this->prefix."users` WHERE `user_id_youtube` IN (?as)", $this->autors_in_list)->fetch_assoc_array()){
                foreach($this->list_users as $user){
                    $this->listusers[$user['user_id_youtube']] = $user;
                }
            }        
        }else{
            //не будем отдавть 404 так как кимментариев к новому видео может еще не оказаться, а доп проверок делать не желательно
            //$error = true;
        }
    }
    
    
    ////Получаем архивный чат
    public function get_list_top_comments(){
        if(!isset($this->list_comments))$this->list_comments = array();
        if(!isset($this->autors_in_list))$this->autors_in_list = array();

        if ($this->topcomment = $this->db->query("SELECT * FROM `".$this->prefix."top_comments` WHERE `id_youtube` = '?s'",$this->preply_to_comment_id)->fetch_assoc()){
            $this->autors_in_list[$this->topcomment['user_id']] = $this->topcomment['user_id'];

            if(isset($this->last_time_comment)){
                $where = " AND STR_TO_DATE(`date`, '%Y-%m-%d  %H:%i:%s') > STR_TO_DATE('" .date("Y-m-d  H:i:s", strtotime($this->last_time_comment)). "', '%Y-%m-%d %H:%i:%s')";
            }else{
                $where = '';
            }

            
            if ($this->list_comments = $this->db->query("SELECT * FROM `".$this->prefix."comments` WHERE `preply_to_comment_id` = '?s'".$where." ORDER BY date DESC LIMIT 300",$this->preply_to_comment_id)->fetch_assoc_array()){
                //собираем уникальных пользователей в чате
                foreach($this->list_comments as $val){
                    $this->autors_in_list[$val['user_id']] = $val['user_id'];
                }
            }

            //запрашиваем инфу по каждому юзеру из бд
            if ($this->list_users = $this->db->query("SELECT * FROM `".$this->prefix."users` WHERE `user_id_youtube` IN (?as)", $this->autors_in_list)->fetch_assoc_array()){
                foreach($this->list_users as $user){
                    $this->listusers[$user['user_id_youtube']] = $user;
                }
            }  
        }else{
            $GLOBALS['error'] = true;
        }
        
    
    }
    
    
    ////Страница внутреннего чата
    public function feedback(){
        $this->autors_in_list = array('1'=>'1');
        //print_r($topcomment);
        if($_SESSION['logged_user']['access'] <= 2){
            $where = "WHERE STR_TO_DATE(`date`, '%Y-%m-%d  %H:%i') > STR_TO_DATE('" .date("Y-m-d  H:i", strtotime($_SESSION['logged_user']['datareg'])). "', '%Y-%m-%d %H:%i') OR `id` = '13'";
        }else{
            $where = '';
        }
        
        
        if ($this->list_comments = $this->db->query("SELECT * FROM `internal_chat` ".$where." ORDER BY date DESC LIMIT 250")->fetch_assoc_array()){
        
                $count = $this->db->query("SELECT COUNT(*) as total FROM `internal_chat` ".$where)->fetch_assoc();//запрашиваем общее количество сообщений в чате
                $this->db->query("UPDATE `users_reg` SET `read_internal_message` = '".$count['total']."' WHERE `id` = '" . $_SESSION['logged_user']['id'] . "' ");//обновляем количество прочитанных сообщений
                $_SESSION['logged_user']['read_internal_message'] = $count['total'];
                $_SESSION['logged_user']['total_internal_message'] = $count['total'];

                $this->response = $count['total'];
        
                foreach($this->list_comments as $val){
                    $this->autors_in_list[$val['from']] = $val['from'];
                    $this->autors_in_list[$val['user_id']] = $val['user_id'];
                }
                //запрашиваем инфу по каждому юзеру из бд
                if ($this->list_users = $this->db->query("SELECT id,login FROM `users_reg` WHERE `id` IN (?as)", $this->autors_in_list)->fetch_assoc_array()){
                    foreach($this->list_users as $user){
                        $this->listusers[$user['id']] = $user['login'];
                    }
        //print_r($listusers);
                }  
        }
    }
    
    ///Сохраняем в базе комментарий внутреннего чата
    public function feedback_save_message($text_message){
        $comment = htmlspecialchars($text_message, ENT_QUOTES);
        $this->db->query('INSERT INTO `internal_chat` SET ?As', array("comment" => $comment, "user_id" => $_SESSION['logged_user']['id'],"from" => $_SESSION['logged_user']['id']));
        //$db->query("UPDATE `users` SET `count_message` = count_message + 1 WHERE `user_id_youtube` = '" . $item['snippet']['authorChannelId']['value'] . "' ");
        
    }
    
    
    
    
    
    ///загрузка списка видео стандартным способом через youtube api
    public function list_video($channelId,$maxResults_list_video){
        $queryParams = [
            'channelId' => $channelId,
            'maxResults' => $maxResults_list_video,
            'order' => 'date'
        ];


        $this->response = $this->service->search->listSearch('snippet', $queryParams);
        //print_r($response);

        $this->list_videos;
        foreach ($this->response['items'] as $key => $items) {
            $this->list_videos[$items['id']['videoId']] = array(
                'id' => $items['id']['videoId'],
                'title' => $items['snippet']['title'],
                'publishedAt' => date("d.m.Y H:i:s", strtotime($items['snippet']['publishedAt'])),
                'description' => $items['snippet']['description'],
                'url_image' => $items['snippet']['thumbnails']['default']['url'],
            );
        }
    }
    
    
        ///загрузка списка видео через плейлист через youtube api
    public function list_video_playlist($playlistId,$maxResults_list_video){
        $queryParams = [
            'playlistId' => $playlistId,
            'maxResults' => $maxResults_list_video
        ];


        $this->response = $this->service->playlistItems->listPlaylistItems('id,snippet', $queryParams);
        //print_r($this->response);

        $this->list_videos;
        foreach ($this->response['items'] as $key => $items) {
            $this->list_videos[$items['snippet']['resourceId']['videoId']] = array(
                'id' => $items['snippet']['resourceId']['videoId'],
                'title' => $items['snippet']['title'],
                'publishedAt' => date("d.m.Y H:i:s", strtotime($items['snippet']['publishedAt'])),
                'description' => $items['snippet']['description'],
                'url_image' => $items['snippet']['thumbnails']['default']['url'],
            );
        }
        //print_r($list_videos);
    }
    
    
    
    ///загрузка списка комментариев через youtube api
    public function list_comments($top_comment_id,$maxResults_comments){
    //список ответов по id родительского комментария
        $param_for_list_reply_top_comment = [
            'maxResults' => $maxResults_comments,
            'parentId' => $top_comment_id
        ];

        $this->response = $this->service->comments->listComments('snippet', $param_for_list_reply_top_comment);


        //print_r($this->response);


        foreach ($this->response['items'] as $item) {
            $this->autors_in_list[$item['snippet']['authorDisplayName']] = $item['snippet']['authorChannelId']['value'];
        }
    }
    
    
    
    ///загрузка списка закрепленных комментариев через youtube api
    public function list_top($video_id,$maxResults_top_comment){
        //print_r($youtube->videos->listVideos('snippet, statistics, contentDetails', ['id' => $video_id,]));
        $param_for_search_top_comment = [
            'maxResults' => $maxResults_top_comment,
            //'order' => 'time',
            'order' => 'relevance',
            'videoId' => $video_id
        ];

        //$response = $service->commentThreads->listCommentThreads('snippet,replies', $queryParams);

        $response_topcomment = $this->service->commentThreads->listCommentThreads('snippet,replies', $param_for_search_top_comment);

        
        $this->response['id_video'] = $response_topcomment['items'][0]['snippet']['topLevelComment']['snippet']['videoId'];
        $this->response['user_id'] = $response_topcomment['items'][0]['snippet']['topLevelComment']['snippet']['authorChannelId']['value'];
        $this->response['top_comment_id'] = $response_topcomment['items'][0]['id'];
        $this->response['total_count_comments'] = $response_topcomment['items'][0]['snippet']['totalReplyCount'];
        $this->response['name_top_comment'] = $response_topcomment['items'][0]['snippet']['topLevelComment']['snippet']['authorDisplayName'];
        $this->response['avatar_top_comment'] = $response_topcomment['items'][0]['snippet']['topLevelComment']['snippet']['authorProfileImageUrl'];
        $this->response['text_top_comment'] = $response_topcomment['items'][0]['snippet']['topLevelComment']['snippet']['textOriginal'];
        $this->response['time_top_comment'] = date("H:i:s", strtotime($response_topcomment['items'][0]['snippet']['topLevelComment']['snippet']['publishedAt']));
        $this->response['originaltime_top_comment'] = $response_topcomment['items'][0]['snippet']['topLevelComment']['snippet']['publishedAt'];
        $this->response['originaltime_update'] = $response_topcomment['items'][0]['snippet']['topLevelComment']['snippet']['updatedAt'];    
    }
}
?>
