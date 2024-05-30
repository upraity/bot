<?php


// Get the input from the Telegram webhook
$input = file_get_contents('php://input');

// Decode the JSON input
$data = json_decode($input);
// $data = $input;

// Check if JSON decoding was successful
// if (json_last_error() !== JSON_ERROR_NONE) {
//     error_log('Failed to decode JSON input: ' . json_last_error_msg());
//     exit('Invalid JSON');
// }

// Extract chat ID and message text from the decoded data
$uname=$data->message->from->first_name;
$chat_id = $data->message->chat->id;
$text = $data->message->text;

// Prepare the response message based on the received text
if ($text == '/start') {
    $msgg = "Welcome ".$uname." to SabkaCode! \nEnter command what you use list is:\n/help \n/about \n/contact \n /support";
}
elseif($text == '/help'){
    $msgg = "Some Commands:\n/hi";
}
elseif($text== '/hi'){
    $msgg = "How we can help you?";    
}
elseif($text == '/about'){
    $msgg = "About Us:\nSabkaCode is a website where you can learn programming languages like PHP, HTML, CSS, JavaScript, Python, Java, C++, C#, and more. Our website is designed to provide you with a comprehensive learning experience and help you master the skills you need to succeed in the programming world. Whether you're a beginner or an experienced programmer, our website has everything you need to get started on your programming journey. From tutorials and examples to interactive coding challenges and quizzes, our website is designed to help you learn and grow as a programmer. We believe that programming is not just a skill, but a lifelong pursuit that you can enjoy every day. So why not give it a try and see what you can learn?";
}
elseif($text == '/contact'){
    $msgg = "Contact us on: \nEmail: sabkacode@gmail.com\nTelegram: @sabkacode\nGithub: github.com/upraity\nInstagram:instagram.com/sabkacode\nFacebook: facebook.com/sabkacode";
}
 else {
    $msgg = "Other Message";
}

// Your Telegram bot token
$token = '<yout bot token>';

// Prepare the URL for sending the message
$url = 'https://api.telegram.org/bot' . $token . '/sendMessage';

// Set up the payload for the POST request
$post_fields = [
    'chat_id' => $chat_id,
    'text' => $msgg,
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
