<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// utilities
use App\Post;
use App\Category;
use Illuminate\Support\Str;

class PostController extends Controller
{
    // index : all-posts   
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->get();
        return view('admin.posts.index', compact('posts'));
    }

    // create post : create a new post
    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required|max:65535',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        $data = $request->all();

        $post = new Post();
        $post->fill($data);

        $slug = $this->calculateSlug($post->title);
        $post->slug = $slug;

        $post->save();

        return redirect()->route('admin.posts.index')->with('status', 'Post succesfully created!');
    }

    // show single post
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    // edit single post
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    // update single post
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required|max:65535',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        $data = $request->all();

        if ($post->title !== $data['title']) {
            $data['slug'] = $this->calculateSlug($data['title']);
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('status', 'Post updated!');
    }

    // delete single post
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('status', 'Post deleted!');
    }

    protected function calculateSlug($title) {
        $slug = Str::slug($title, '-');
        $checkPost = Post::where('slug', $slug)->first();
        $slug = substr($slug, 0, 50);
        $counter = 1;

        while($checkPost) {
            $slug = Str::slug($title . '-' . $counter, '-');
            $counter++;
            $checkPost = Post::where('slug', $slug)->first();
        }

        return $slug;
    }
}
