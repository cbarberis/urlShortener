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
		$tabName = ($this->owner instanceof SiteTree) ? 'Root.Content.SocialMedia' : 'Root.SocialMedia';
		$fields->addFieldToTab($tabName, new HeaderField('ShortHeader', 'URL Shortener', 4));
		if(!UrlShortener::ready_to_short()) 
			$fields->addFieldToTab($tabName, new LiteralField('NotGoodToShort', '<p>ATTENTION: This will NOT make shorten, you need to set your bitly API credentials</p>'));
		$fields->addFieldToTab($tabName, new CheckboxField('ShortUrlOpt', 'Short Url'));
		$fields->addFieldToTab($tabName, new ReadonlyField('ShortUrl', 'Short Url'));
		
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