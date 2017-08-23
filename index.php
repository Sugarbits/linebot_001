<?php
include_once('judge.php');
include_once('reply.php');
$access_token ='iBNDaju5Omo3YKNW1Le81i0s9cw76Sh8KdfwpBoPyinZUHV0qKwBDFPStJvZW4i+bopntfucMvomTzpCKOUdj/OtK5Frl/opeYLhyhC2o4m5jML3LL+B0T7uIC3HKO0t/Zni5/fZhHajxe/eM7zzDQdB04t89/1O/w1cDnyilFU=';
//define('TOKEN', '你的Channel Access Token');
$json_string = file_get_contents('php://input');

//$file = fopen("C:\\Line_log.txt", "a+");
$file = fopen("Line_log.txt", "a+");
fwrite($file, $json_string."\n"); 
$json_obj = json_decode($json_string);

$event = $json_obj->{"events"}[0];
	// 讀取訊息的型態 [Text, Image, Video, Audio, Location, Sticker]
$type  = $event->{"message"}->{"type"};
$message = $event->{"message"};
$reply_token = $event->{"replyToken"};

$answer = judge($type,$message);

$post_data = [
  "replyToken" => $reply_token,
  "messages" => [
    [
      "type" => "text",
      //"text" => "回復：".$message->{"text"}
      "text" => $answer
    ]
  ]
]; 
fwrite($file, json_encode($post_data)."\n");

$ch = curl_init("https://api.line.me/v2/bot/message/reply");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer '.$access_token
    //'Authorization: Bearer '. TOKEN
));
$result = curl_exec($ch);
fwrite($file, $result."\n");  
fclose($file);
curl_close($ch); 


?>