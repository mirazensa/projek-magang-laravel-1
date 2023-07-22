<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;

class PostController extends Controller
{
    public function index()
    {
        $title = '';
        if (request('category')) {
            $category = Category::firstWhere('slug', request('category'));
            $title = ' in ' . $category->name;
        }
        if (request('author')) {
            $author = User::firstWhere('username', request('author'));
            $title = ' By ' . $author->name;
        }

        return view('posts', [
            'title' => 'All Posts' . $title,
            'active' => 'blog',
            'categories' => Category::all(),
            // 'posts' => Post::all(),
            'posts' => Post::latest()
                ->filter(request(['search', 'category', 'author']))
                ->paginate(7)
                ->withQueryString(),
        ]);
    }

    public function show(Post $post)
    {
        return view('post', [
            'title' => 'single Post',
            'active' => 'blog',
            'post' => $post,
        ]);
    }

    // public function getRouteKeyName()
    // {
    //     return 'slug';
    // }
}
