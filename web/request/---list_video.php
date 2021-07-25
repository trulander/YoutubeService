<?
$queryParams = [
    'channelId' => $channelId,
    'maxResults' => $maxResults_list_video,
    'order' => 'date'
];


$response = $service->search->listSearch('snippet', $queryParams);
print_r($response);

$list_videos;
foreach ($response['items'] as $key => $items) {
	$list_videos[$items['id']['videoId']] = array(
		'id' => $items['id']['videoId'],
		'title' => $items['snippet']['title'],
		'publishedAt' => date("d.m.Y H:i:s", strtotime($items['snippet']['publishedAt'])),
		'description' => $items['snippet']['description'],
		'url_image' => $items['snippet']['thumbnails']['default']['url'],
	);
}
//print_r($list_videos);
?>
