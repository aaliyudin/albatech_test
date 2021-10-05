<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;
use Auth;

class CategoryController extends Controller
{
  public function index()
  {
    $category = Category::all();
    $data = [
      'categories' => $category
    ];

    return response()->json(
      [
        'status_code' => 200,
        'success' => true,
        'message' => 'Get Data Categories Success',
        'data' => $data
      ], 200);
  }

  public function show($id)
  {
    $category = Category::find($id);
    $data = [
      'category' => $category
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
    $category = new Category();
    $category->category_name = $request->category_name;
    $category->save();

    return response()->json(
      [
        'status_code' => 200,
        'success' => true,
        'message' => 'Create Category Success',
        'data' => []
      ], 200);
  }

  public function update(Request $request, $id)
  {
    $tags = explode(",", $request->tags);

    $category = Category::find($id);
    $category->category_name = $request->category_name;
    $category->save();

    return response()->json(
      [
        'status_code' => 200,
        'success' => true,
        'message' => 'Update Data Category Success',
        'data' => []
      ], 200);
  }

  public function delete($id)
  {
    $category = Category::find($id);
    $category->delete();

    return response()->json(
      [
        'status_code' => 200,
        'success' => true,
        'message' => 'Delete Data Category Success',
        'data' => []
      ], 200);
  }
}
