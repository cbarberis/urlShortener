<?php

class UrlShortenerDecorator extends DataObjectDecorator {
	
	function extraStatics() {
		return array(
			"db" => array(
				"ShortUrl" => "Varchar(255)"
			)
		);
	}
	
	function updateCMSFields(&$fields) {
	
		$fields->addFieldToTab('Root.Content.UrlShortener', new CheckboxField('ShortUrlOpt', 'Short Url'));
		$fields->addFieldToTab('Root.Content.UrlShortener', new ReadonlyField('ShortUrl', 'Short Url'));
		
	}
	
	public $ShortUrlOpt = false;
	
	function setShortUrlOpt($value) { $this->ShortUrlOpt = $value; }
	
	function onBeforeWrite(){
		if($this->ShortUrlOpt) {
			$shortener = new UrlShortener();
			$this->owner->ShortUrl = $shortener->makeShortUrl($this->owner->AbsoluteLink());
		}
	}

}