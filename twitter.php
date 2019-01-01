<?php
require 'feed.php';
require 'simple_html_dom.php';
header("Cache-Control: no-cache");
if(isset($_GET['userName'])){
	$username = $_GET['userName'];
	$url = 'https://twitter.com/'.$username;
	$feed = new feed($url,$username);
	$feed->title = 'Twitter '.$username;
	$feed->author = $username;
	$html = file_get_html($url);
	foreach($html->find('.stream-item') as $item){
		$content = null;
		$date = null;
		foreach($item->find('.js-tweet-text-container') as $e){
			$src = $e->first_child();
			$plaintext = str_replace(((string)$e->first_child()->last_child()),'',$src);
			$contenthtml = str_get_html($plaintext);
			$content = html_entity_decode(preg_replace_callback("/(&#[0-9]+;)/", function($m) { return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES"); }, $contenthtml->plaintext));
		}
		foreach($item->find('.js-short-timestamp') as $e){
			$date = $e->getAttribute('data-time');
		}
		$id = $item->getAttribute('data-item-id');
		$link = $url.'/status/'.$id;
		$title = substr($content,0,50);
		if($title != ""){
			$item  = $feed->newItem($link,$title);
			$item->updated = $date;
			$item->content = $content;
			$item->link = '/'.$username.'/status/'.$id;
		}
	}
	$feed->printFeed();
}
