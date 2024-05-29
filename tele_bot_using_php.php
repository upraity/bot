<?php
// Function to check if the text is a URL
function isValidUrl($text) {
    // Regular expression pattern to detect URLs
    $urlPattern = '/https?:\/\/(?:[-\w.]|(?:%[\da-fA-F]{2}))+/';
    // Check if the pattern matches the text
    return preg_match($urlPattern, $text) === 1;
}

// Get input data
$input = file_get_contents('php://input');
$data = json_decode($input);
$uname = $data->message->from->first_name;
$chat_id = $data->message->chat->id;
$text = $data->message->text;

if ($text == '/start') {
    $msg = "Hello $uname, Welcome to SabkaCode Short Link Bot\nEnter your link to get short link"; // msg that you want to.....
}
// elseif($text == '/help'){
//   $msg = "";
// }
else {
    if (isValidUrl($text)) {
        $url = urlencode($text); // URL encode the input URL
        $json = file_get_contents("https://htmlify.artizote.com/api/shortlink?url=$url");
        $data1 = json_decode($json, true);
        $msg = "Here is your short link: " . $data1['url'];
    } else {
        $msg = "Invalid URL. Please enter a valid link.";
    }
}

// Prepare the URL for sending the message
$token = '<your bot token>';
$url = 'https://api.telegram.org/bot' . $token . '/sendMessage';

// Set up the payload for the POST request
$post_fields = [
    'chat_id' => $chat_id,
    'text' => $msg,
    'parse_mode' => 'HTML'
];

// Initialize CURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the CURL request
$result = curl_exec($ch);

// Check for CURL errors
if ($result === false) {
    error_log('CURL error: ' . curl_error($ch));
} else {
    // Optionally, log the result for debugging
    error_log('CURL result: ' . $result);
}

// Close the CURL session
curl_close($ch);
?>
