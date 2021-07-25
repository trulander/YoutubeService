<?
$queryParams = [
    'playlistId' => $playlistId,
    'maxResults' => $maxResults_list_video
];


$response = $service->playlistItems->listPlaylistItems('id,snippet', $queryParams);
//print_r($response);

$list_videos;
foreach ($response['items'] as $key => $items) {
	$list_videos[$items['snippet']['resourceId']['videoId']] = array(
		'id' => $items['snippet']['resourceId']['videoId'],
		'title' => $items['snippet']['title'],
		'publishedAt' => date("d.m.Y H:i:s", strtotime($items['snippet']['publishedAt'])),
		'description' => $items['snippet']['description'],
		'url_image' => $items['snippet']['thumbnails']['default']['url'],
	);
}
//print_r($list_videos);
?>
