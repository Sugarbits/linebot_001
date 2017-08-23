<?php
//judge
function judge($type,$message){
	$judge = array(0,'');
	$message->{"text"};
	switch($type) {
			case "text" :
				$content_type = "文字訊息";
				$data = ["to" => $from, "messages" => array(["type" => "text", "text" => $message])];
				break;
				
			case "image" :
				$content_type = "圖片訊息";
				//$message = getObjContent("jpeg");   // 讀取圖片內容
				//$data = ["to" => $from, "messages" => array(["type" => "image", "originalContentUrl" => $message, "previewImageUrl" => $message])];
				break;
				
			case "video" :
				$content_type = "影片訊息";
				$message = getObjContent("mp4");   // 讀取影片內容
				$data = ["to" => $from, "messages" => array(["type" => "video", "originalContentUrl" => $message, "previewImageUrl" => $message])];
				break;
				
			case "audio" :
				$content_type = "語音訊息";
				$message = getObjContent("mp3");   // 讀取聲音內容
				$data = ["to" => $from, "messages" => array(["type" => "audio", "originalContentUrl" => $message[0], "duration" => $message[1]])];
				break;
				
			case "location" :
				$content_type = "位置訊息";
				$title = $message->title;
				$address = $message->address;
				$latitude = $message->latitude;
				$longitude = $message->longitude;
				$data = ["to" => $from, "messages" => array(["type" => "location", "title" => $title, "address" => $address, "latitude" => $latitude, "longitude" => $longitude])];
				break;
				
			case "sticker" :
				$content_type = "貼圖訊息";
				//"id":"6586081093764","stickerId":"407"
				
				$id = $message->{'id'};
				$packageid = $message->{'packageId'};
				$stickerid = $message->{'stickerId'};
				//$content_type .= $id;
				$content_type.=$stickerid;
				if($stickerid == '408'){
					$judge[0] = 1;
				}
				$data = ["to" => $from, "messages" => array(["type" => "sticker", "packageId" => $packageId, "stickerId" => $stickerId])];
				break;
				
			default:
				$content_type = "未知訊息";
				break;
	}
	if($judge[0] == 0){
		$judge[1] = '這是'.$content_type.'嗎？';
		return $judge[1];
	}elseif($judge[0] == 1){
		$judge[1] = '孟竹吃大便喔！';
		return $judge[1];
	}
	
}
?>