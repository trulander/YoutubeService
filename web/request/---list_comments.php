<?

//список ответов по id родительского комментария
$param_for_list_reply_top_comment = [
    'maxResults' => $maxResults_comments,
    'parentId' => $top_comment_id
];

$response_comment = $service->comments->listComments('snippet', $param_for_list_reply_top_comment);


//print_r($response_comment);


foreach ($response_comment['items'] as $item) {
	$autors_in_list[$item['snippet']['authorDisplayName']] = $item['snippet']['authorChannelId']['value'];
}
?>
