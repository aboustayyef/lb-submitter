<?php 
namespace App;
use \Illuminate\Support\Collection;
use \Exception;
use \SimplePie;
/**
* 			
*/
class FeedFetcher
{
	public $status, $finalItems;
	private $feed, $sp ; // the simplepie object

	public function __construct($feed)
	{
		$this->feed = $feed;
		$this->sp = new SimplePie();
		$this->sp->set_feed_url($this->feed);
		$this->sp->set_cache_location(storage_path().'/cache');
		$this->sp->init();

		$items = new Collection($this->sp->get_items(0,10));
		$this->finalItems = $items->map(function($item){
			return [
				'title'		=>		$item->get_title(),
				'url'		=>		$item->get_link()
			];
		});

		$this->status = $this->finalItems->count() > 0 ? 'ok' : 'error';

		// $feed->enable_cache(true);
	}
}
?>