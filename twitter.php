<?php
require 'feed.php';
header("Cache-Control: no-cache");
error_reporting(0);
if(isset($_GET['userName'])){
	$username = $_GET['userName'];
	$url = 'https://twitter.com/'.$username;
	$feed = new feed($url,$username);
	$feed->title = 'Twitter '.$username;
	$feed->author = $username;
	$file = file_get_contents($url);
	$doc = new DOMDocument();
	$doc->loadHTML($file);
	$items = $doc->getElementById('stream-items-id');
	$counter = 0;
	foreach($items->childNodes as $item){
		if($item->tagName == 'li'){
			$wrapper = ($item->childNodes)[1];
			foreach($wrapper->childNodes as $wrapperItem){
				if($wrapperItem->tagName == 'div'){
					$header = ($wrapperItem->childNodes)[1];
					$date = ($header->childNodes)[3];
					$content = ($wrapperItem->childNodes)[3];
					if($header != null){
						$title = substr($content->textContent,0,50);
						$item = $feed->newItem($url.'?'.$counter,$title);
						$item->content = $content->textContent;
					}
				}
			}
		$counter++;
		}
	}
	$feed->printFeed();
}