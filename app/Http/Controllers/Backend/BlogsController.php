<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogsCategory;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Models\Blog;

class BlogsController extends Controller
{
    // ── Create view
    public function create()
    {
        $categories = BlogsCategory::all();
        return view('backend.blogs.create', compact('categories'));
    }

    // ── Index view with all blogs
    public function index()
    {
        $blogs = Blog::latest()->paginate(10);
        return view('backend.blogs.index', compact('blogs'));
    }
    // crete blog
    public function store(Request $request)
    {        
        
        $request->validate([
            'title' => 'required|string|max:255|unique:blogs,title',
            'category_id' => 'required|exists:blogs_categories,id',
            'short_description' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ], [
            'title.required' => 'Blog title is required.',
            'title.unique'   => 'A blog with this title already exists.',
            'title.max'      => 'Blog title must not exceed 255 characters.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'Selected category does not exist.',
            'short_description.required' => 'Blog short description is required.',
            'featured_image.image' => 'Featured image must be an image file.',
            'featured_image.mimes' => 'Featured image must be a file of type: jpeg, png, jpg, gif, svg, webp.',
            'featured_image.max' => 'Featured image must not exceed 5048 kilobytes.',
        ]);
        // insert blog
        $blog = new Blog();
        $blog->title = $request->title;
        $blog->slug = Str::slug($request->title);   
        $blog->category_id = $request->category_id;
        $blog->short_description = $request->short_description;
        $blog->description = $request->description;
        $blog->status = $request->status;
        $blog->meta_title = $request->meta_title;
        $blog->meta_description = $request->meta_description;
        $blog->meta_keywords = $request->meta_keywords;
        $blog->published_at = Carbon::now()->toDateTimeString();
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('blogs', 'public');
            $blog->featured_image = $path;
        }
        $blog->save();
        return redirect()->route('admin.blogs.index')
                         ->with('success', 'Blog created successfully.');
    }

    // ── Edit view
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        $categories = BlogsCategory::all();
        return view('backend.blogs.update', compact('blog', 'categories'));
    }
    // update blog
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);  
        $request->validate([
            'title' => ['required', 'string', 'max:255', Rule::unique('blogs')->ignore($blog->id)],
            'category_id' => 'required|exists:blogs_categories,id',
            'short_description' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ], [
            'title.required' => 'Blog title is required.',
            'title.unique'   => 'A blog with this title already exists.',
            'title.max'      => 'Blog title must not exceed 255 characters.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'Selected category does not exist.',
            'short_description.required' => 'Blog short description is required.',
            'featured_image.image' => 'Featured image must be an image file.',
            'featured_image.mimes' => 'Featured image must be a file of type: jpeg, png, jpg, gif, svg, webp.',
            'featured_image.max' => 'Featured image must not exceed 5048 kilobytes.',
        ]);
        $blog->title = $request->title;
        $blog->slug = Str::slug($request->title);
        $blog->category_id = $request->category_id;
        $blog->short_description = $request->short_description;
        $blog->description = $request->description;
        $blog->status = $request->status;
        $blog->meta_title = $request->meta_title;
        $blog->meta_description = $request->meta_description;
        $blog->meta_keywords = $request->meta_keywords;
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($blog->featured_image && Storage::disk('public')->exists($blog->featured_image)) {
                Storage::disk('public')->delete($blog->featured_image); 
            }
            $path = $request->file('featured_image')->store('blogs', 'public');
            $blog->featured_image = $path;  
        }
        $blog->save();
        return redirect()->route('admin.blogs.index')
                         ->with('success', 'Blog updated successfully.');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        if ($blog->featured_image && Storage::disk('public')->exists($blog->featured_image)) {
            Storage::disk('public')->delete($blog->featured_image); 
        }
        $blog->delete();
        return redirect()->route('admin.blogs.index')
                         ->with('success', 'Blog deleted successfully.');
    }
}
