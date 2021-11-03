<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request){
    	$posts = Post::orderBy('id', 'desc')->paginate('10');
    	return view('blog.index')
    	->with('posts', $posts);
    }

    public function singlePost(Request $request, $excerpt, $id){
    	$post = Post::where('id', $id)->first();

    	return view('blog.post')
    	->with('post', $post);
    }
}
