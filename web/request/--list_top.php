<?

//print_r($youtube->videos->listVideos('snippet, statistics, contentDetails', ['id' => $video_id,]));
$param_for_search_top_comment = [
    'maxResults' => $maxResults_top_comment,
    //'order' => 'time',
    'order' => 'relevance',
    'videoId' => $video_id
];

//$response = $service->commentThreads->listCommentThreads('snippet,replies', $queryParams);

$response_topcomment = $service->commentThreads->listCommentThreads('snippet,replies', $param_for_search_top_comment);

$id_video = $response_topcomment['items'][0]['snippet']['topLevelComment']['snippet']['videoId'];
$user_id = $response_topcomment['items'][0]['snippet']['topLevelComment']['snippet']['authorChannelId']['value'];
$top_comment_id = $response_topcomment['items'][0]['id'];
$total_count_comments = $response_topcomment['items'][0]['snippet']['totalReplyCount'];
$name_top_comment = $response_topcomment['items'][0]['snippet']['topLevelComment']['snippet']['authorDisplayName'];
$avatar_top_comment = $response_topcomment['items'][0]['snippet']['topLevelComment']['snippet']['authorProfileImageUrl'];
$text_top_comment = $response_topcomment['items'][0]['snippet']['topLevelComment']['snippet']['textOriginal'];
$time_top_comment = date("H:i:s", strtotime($response_topcomment['items'][0]['snippet']['topLevelComment']['snippet']['publishedAt']));
$originaltime_top_comment = $response_topcomment['items'][0]['snippet']['topLevelComment']['snippet']['publishedAt'];
$originaltime_update = $response_topcomment['items'][0]['snippet']['topLevelComment']['snippet']['updatedAt'];

?>
