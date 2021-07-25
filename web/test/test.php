<?
        ini_set('error_reporting', E_ALL);
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
    //require_once (dirname(__FILE__).'/../sys/core.php');
    
    
	require_once (dirname(__FILE__).'/../../vendor/autoload.php');


    
    
    
    
   function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('People API PHP Quickstart');
    $client->setScopes([
        'https://www.googleapis.com/auth/youtube.force-ssl',
    ]);

    $client->setAuthConfig('credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');

    // Load previously authorized token from a file, if it exists.
    // The file token.json stores the user's access and refresh tokens, and is
    // created automatically when the authorization flow completes for the first
    // time.
    $tokenPath = 'token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }

    // If there is no previous token or it's expired.
    if ($client->isAccessTokenExpired()) {
        // Refresh the token if possible, else fetch a new one.
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim('4/qQF9Ix0k_XmuHHZa8DTaLVjwDk2axSXkviK_Kxn906BzUpZ1n0_npys');

            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            $client->setAccessToken($accessToken);

            // Check to see if there was an error.
            if (array_key_exists('error', $accessToken)) {
                throw new Exception(join(', ', $accessToken));
            }
        }
        // Save the token to a file.
        if (!file_exists(dirname($tokenPath))) {
            mkdir(dirname($tokenPath), 0700, true);
        }
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
    return $client;
}


// Get the API client and construct the service object.
$client = getClient();






    //require_once (dirname(__FILE__).'/../sys/google_api.php');

// Define service object for making API requests.
$service = new Google_Service_YouTube($client);



/*

//print_r($youtube->videos->listVideos('snippet, statistics, contentDetails', ['id' => $video_id,]));
$param_for_search_top_comment = [
    'maxResults' => '10',
    //'order' => 'time',
    'order' => 'relevance',
    'videoId' => 'koiZHrwtN1U'
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
print_r($response_topcomment);



//UgyioVrKYzoZ0C7Elfl4AaABAg

*/






// Define the $comment object, which will be uploaded as the request body.
$comment = new Google_Service_YouTube_Comment();


// Add 'snippet' object to the $comment object.
$commentSnippet = new Google_Service_YouTube_CommentSnippet();
$commentSnippet->setParentId('UgzUEZxDOdTXnAibzk94AaABAg');
$commentSnippet->setTextOriginal('Растем))');
$comment->setSnippet($commentSnippet);

$response = $service->comments->insert('snippet', $comment);
print_r($response);





/*
//оставить коммент под видео

$commentThread = new Google_Service_YouTube_CommentThread();

// Add 'snippet' object to the $commentThread object.
$commentThreadSnippet = new Google_Service_YouTube_CommentThreadSnippet();
$comment = new Google_Service_YouTube_Comment();
$commentSnippet = new Google_Service_YouTube_CommentSnippet();
$commentSnippet->setTextOriginal('This is the start of a comment thread.');
$comment->setSnippet($commentSnippet);
$commentThreadSnippet->setTopLevelComment($comment);
$commentThreadSnippet->setVideoId('koiZHrwtN1U');
$commentThread->setSnippet($commentThreadSnippet);

$response = $service->commentThreads->insert('snippet', $commentThread);
print_r($response);
*/


?>
