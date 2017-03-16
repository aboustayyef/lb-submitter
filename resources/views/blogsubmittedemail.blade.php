<h1>
	The following blog has just been submitted to Lebanese Blogs
</h1>

<p>
	@foreach($details as $key => $detail)
	{{$key}}: {{$detail}}<br/>
	@endforeach

	Click <a href="{{env('APP_ROOT_URL')}}/approve?blogId={{$details['blog_id']}}&token={{md5($details['blog_rss_feed'])}}_{{$details['id']}}">here</a> to approve this blog
</p>
		