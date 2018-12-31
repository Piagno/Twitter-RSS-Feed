<?php
class feed{
	//Based on https://validator.w3.org/feed/docs/atom.html
	var $id;
	var $title;
	var $updated;
	var $author = null;
	var $link = null;
	var $items = array();
	function feed($id,$title){
		$this->id = $id;
		$this->title = $title;
		$this->updated = date('Y-m-d\TH:i:s\Z');
		$this->link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";;
	}
	function newItem($id,$title){
		$item = new class($id,$title){
			var $id;
			var $title; 
			var $updated;
			var $content = null;
			function __construct($id,$title){
				$this->id = $id;
				$this->title = $title;
				$this->updated = date('Y-m-d\TH:i:s\Z');
			}
			function getItem(){
				$this->print = '<entry>';
				$this->print .= '<id>'.$this->id.'</id>';
				$this->print .= '<title>'.$this->title.'</title>';
				$this->print .= '<updated>'.$this->updated.'</updated>';
				if($this->content != null){
					$this->print .= '<content>'.$this->content.'</content>';
				}
				$this->print .= '</entry>';
				return $this->print;
			}
		};
		$this->items[] = $item;
		return $item;
	}
	function getFeed(){
		$print = '<?xml version="1.0" encoding="utf-8"?><feed xmlns="http://www.w3.org/2005/Atom">';
		$print .= '<id>'.$this->id.'</id>';
		$print .= '<title>'.$this->title.'</title>';
		$print .= '<updated>'.$this->updated.'</updated>';
		if($this->author != null){
			$print .= '<author><name>'.$this->author.'</name></author>';
		}
		if($this->link != null){
			$print .= '<link rel="self" href="'.$this->link.'" />';
		}
		foreach($this->items as $item){
			$print .= $item->getItem();
		}
		$print .= '</feed>';
		return $print;
	}
	function printFeed($withHeader = true){
		if($withHeader){
			header('Content-Type: application/xml');
		}
		echo $this->getFeed();
	}
}
?>