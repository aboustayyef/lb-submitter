<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blog;

class ApprovementController extends Controller
{
    function check(Request $request){
        
        // make sure there are no problems with request
        $check = $this->guard($request);
        if ($check != 'ok'){
            return $check;
        }

        // if all is ok;
        $blog = Blog::where('blog_id',$request->get('blogId'))->first();
        $blog->blog_RSSCrawl_active = 1;
        $blog->reason_for_deactivation = '';
        $blog->save();
        return 'Blog Approved';
    }

    private function guard($request){

        // make sure $request has a blogId and token

        if (! $request->get('token') || ! $request->get('blogId')){
            return 'you have to have a blog id and a token';
        }

        // Check that blog exists

        $blogExists = Blog::where('blog_id',$request->get('blogId'))->get()->count();
        if ($blogExists == 0) {
            return 'This blog doesn\'t exsit';
        }

        $blog = Blog::where('blog_id',$request->get('blogId'))->first();
        
        // Check that the blog is not approved yet

        if ($blog->blog_RSSCrawl_active == 1) {
            return 'this blog is already approved';
        }

        // Check if token matches;
        if ($request->get('token') != md5($blog->blog_rss_feed) . '_' . $blog->id ) {
            return 'Wrong Token';
        }

        return 'ok';

    }

}
