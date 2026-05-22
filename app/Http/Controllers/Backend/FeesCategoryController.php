<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeesCategory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FeesCategoryController extends Controller
{
    // ── Create view
    public function create()
    {
        return view('backend.price_category.create');
    }

    // ── Index view with all categories
    public function index()
    {
        $categories = FeesCategory::latest()->paginate(10);
        return view('backend.price_category.index', compact('categories'));
    }

    // ── Store
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255|unique:fees_categories,category_name',
        ], [
            'category_name.required' => 'Category name is required.',
            'category_name.unique'   => 'A category with this name already exists.',
            'category_name.max'      => 'Category name must not exceed 255 characters.',
        ]);

        FeesCategory::insert([
            'category_name' => $request->category_name,
            'slug'          => Str::slug($request->category_name),
            'created_at'    => Carbon::now(),
        ]);

        return redirect()->route('admin.fees-category.index')
                         ->with('success', 'Category created successfully.');
    }

    // ── Edit view
    public function edit($id)
    {
        $category = FeesCategory::findOrFail($id);
        return view('backend.price_category.update', compact('category'));
    }

    // ── Update
    public function update(Request $request, $id)
    {
        $category = FeesCategory::findOrFail($id);

        $request->validate([
            'category_name' => 'required|string|max:255|unique:fees_categories,category_name,' . $id,
        ], [
            'category_name.required' => 'Category name is required.',
            'category_name.unique'   => 'A category with this name already exists.',
            'category_name.max'      => 'Category name must not exceed 255 characters.',
        ]);

        $update=FeesCategory::where('id',$id)->update([
            'category_name' => $request->category_name,
            'slug'          => Str::slug($request->category_name),
        ]);

        return redirect()->route('admin.fees-category.index')
                         ->with('success', 'Category updated successfully.');
    }

    // ── Delete
    public function destroy($id)
    {
        $category = FeesCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.fees-category.index')
                         ->with('success', 'Category deleted successfully.');
    }
}
