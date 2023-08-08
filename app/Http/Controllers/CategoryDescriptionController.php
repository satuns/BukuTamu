<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryDescription;

class CategoryDescriptionController extends Controller
{
    public function index() {
        return view('category-description.index', [
            'categories' => CategoryDescription::all()
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
        ]);

        CategoryDescription::create($request->all());
        return redirect('/category-description')->with('tambah', 'Data kategori berhasil ditambahkan');
    }

    public function update(Request $request, CategoryDescription $categoryDescription) {
        $request->validate([
            'ename' => 'required',
        ]);

        CategoryDescription::where('id', $categoryDescription->id)
            ->update([
                'name' => $request->ename
            ]);

        return redirect('/category-description')->with('update', 'Data kategori berhasil diupdate');
    }

    public function destroy(CategoryDescription $categoryDescription)
    {
        CategoryDescription::destroy($categoryDescription->id);
        return redirect('/category-description')->with('hapus', 'Data kategori keperluan berhasil dihapus');
    }
}
