<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;
use Auth;

class TagController extends Controller
{
  public function index()
  {
    $tag = Tag::all();
    $data = [
      'tags' => $tag
    ];

    return response()->json(
      [
        'status_code' => 200,
        'success' => true,
        'message' => 'Get Data Tags Success',
        'data' => $data
      ], 200);
  }

  public function show($id)
  {
    $tag = Tag::find($id);
    $data = [
      'tag' => $tag
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
    $tag = new Tag();
    $tag->tag_name = $request->tag_name;
    $tag->save();

    return response()->json(
      [
        'status_code' => 200,
        'success' => true,
        'message' => 'Create Tag Success',
        'data' => []
      ], 200);
  }

  public function update(Request $request, $id)
  {
    $tag = Tag::find($id);
    $tag->tag_name = $request->tag_name;
    $tag->save();

    return response()->json(
      [
        'status_code' => 200,
        'success' => true,
        'message' => 'Update Data Tag Success',
        'data' => []
      ], 200);
  }

  public function delete($id)
  {
    $tag = Tag::find($id);
    $tag->delete();

    return response()->json(
      [
        'status_code' => 200,
        'success' => true,
        'message' => 'Delete Data Tag Success',
        'data' => []
      ], 200);
  }
}
