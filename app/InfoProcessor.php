<?php

namespace App;
use App\Blog;

class InfoProcessor

{

	public $blog_url, $blog_author_twitter_username, $blog_name, $blog_id, $blog_description, $blog_rss_feed;

	public function __construct($details)
    {

    	// image processing;

    	// mapping web app structure to lb data structure
		$this->blog_url = $details['blog_url'];
		$this->blog_author_twitter_username = $details['twitter'];
		$this->blog_name = $details['Blog_Title'];
		$this->blog_id = $details['Unique_Blog_Username'];
		$this->blog_description = $details['Blog_Description'];
		$this->blog_rss_feed = $details['RSS'];
    }
}