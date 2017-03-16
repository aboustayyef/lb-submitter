<?php

namespace App;
use Image;

class InfoProcessor

{

	public $details;

	public function __construct($details)
    {

    	// save twitter image;
 		$filename = time().'-'. $details['Unique_Blog_Username'];
 		$i = Image::make($details['twitterImage']);
 		$i->fit(200,200)->encode('jpg')->save(env('THUMBS_FOLDER').'/'.$filename.'.jpg', 60);

 		$this->details = [
 		'blog_thumb' => $filename,
		'blog_url' => $details['blog_url'],
		'blog_author_twitter_username' => $details['twitter'],
		'blog_tags'	=> implode(',', $details['blog_tags']),
		'blog_name' => $details['Blog_Title'],
		'blog_id' => $details['Unique_Blog_Username'],
		'blog_description' => $details['Blog_Description'],
		'blog_rss_feed' => $details['RSS'],
		'blog_RSSCrawl_active' => 0,
		'reason_for_deactivation' => 'blog not activated yet',
		'blog_last_post_timestamp'	=> time(),
		'blog_crawlingType'	=> ' ',
 		];

 		Blog::create($this->details);
 		$blog = Blog::where('blog_id', $this->details['blog_id'])->first();
 		$this->details['id'] = $blog->id;
 		\Mail::to('mustapha.hamoui@gmail.com')->send(new \App\Mail\ANewBlogHasBeenSubmitted($this->details));


    }
}