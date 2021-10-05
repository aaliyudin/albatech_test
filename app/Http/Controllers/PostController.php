<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;
use Auth;

class PostController extends Controller
{
  public function index()
  {
    $posts = Post::all();
    $data = [
      'posts' => $posts
    ];

    return response()->json(
      [
        'status_code' => 200,
        'success' => true,
        'message' => 'Get Data Posts Success',
        'data' => $data
      ], 200);
  }

  public function show($id)
  {
    $posts = Post::find($id);
    $data = [
      'post' => $post
    ];

    return response()->json(
      [
        'status_code' => 200,
        'success' => true,
        'message' => 'Get Data Success',
        'data' => $data
      ], 200);
  }

  public function create(Request $request)
  {
    $tags = explode(",", $request->tags);

    $post = new Post();
    $post->category_id = $request->category_id;
    $post->tags = json_encode($tags);
    $post->title = $request->title;
    $post->article = $request->article;
    $post->footer = $request->footer;
    $post->created_by = $request->created_by;
    $post->save();

    foreach ($tags as $key => $tag) {
      $tag = Tag::updateOrCreate(
        ['tag_name' => $tag], ['tag_name' => $tag]
      );
    }

    return response()->json(
      [
        'status_code' => 200,
        'success' => true,
        'message' => 'Create Post Success',
        'data' => []
      ], 200);
  }

  public function update(Request $request, $id)
  {
    $tags = explode(",", $request->tags);

    $post = Post::find($id);
    $post->category_id = $request->category_id;
    $post->tags = json_encode($tags);
    $post->title = $request->title;
    $post->article = $request->article;
    $post->footer = $request->footer;
    $post->created_by = $request->created_by;
    $post->save();

    return response()->json(
      [
        'status_code' => 200,
        'success' => true,
        'message' => 'Update Data Post Success',
        'data' => []
      ], 200);
  }

  public function delete($id)
  {
    $post = Post::find($id);
    $post->delete();

    return response()->json(
      [
        'status_code' => 200,
        'success' => true,
        'message' => 'Delete Data Post Success',
        'data' => []
      ], 200);
  }
}
