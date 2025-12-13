<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriesResource;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Categories::latest()->paginate(10);
        return new CategoriesResource(true, 'List Data Posts', $categories);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'   => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal!',
                'errors' => $validator->errors()
            ], 422);
        }

        $categories = Categories::create([
            'name'   => $request->name,
        ]);
        return new CategoriesResource(true, 'Data Categori Berhasil Ditambahkan!', $categories);
    }

    public function show($id)
    {
        $categories = Categories::find($id);

        if (!$categories) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan!'
            ], 404);
        }

        return new CategoriesResource(true, 'Detail Data Categori!', $categories);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name'   => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal!',
                'errors' => $validator->errors()
            ], 422);
        }

        $categories = Categories::find($id);

        if (!$categories) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan!'
            ], 404);
        }

        $categories->update([
            'name' => $request->name,
        ]);

        return new CategoriesResource(true, 'Data Category Berhasil Diubah!', $categories);
    }
    public function destroy($id)
    {
        $category = Categories::find($id);

        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan!'
            ], 404);
        }

        $category->delete();

        return new CategoriesResource(true, 'Data Category Berhasil Dihapus!', null);
    }
}
