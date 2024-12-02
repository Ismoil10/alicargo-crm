<?

	$mResult = [
    [
        "type" => "article",
        "id" => "first12",
        "title" => $inline_query_text,
        "description" => "50 000 so`m",
        "input_message_content" => ["message_text" => "/start"],
    	"thumb_url"=> "https://ya.senet.uz/bot/sample.png",
		"thumb_width"=>	80,
		"thumb_height"=> 80
	]
];


bot::answerInlineQuery($inline_query_id, $mResult);



?>