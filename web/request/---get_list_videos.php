<?
    $list_videos = array();
    if (!$list_videos = $db->query("SELECT * FROM `eliseev_videos` ORDER BY date DESC LIMIT 10")->fetch_assoc_array()){
        
    }
?>
