<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    // index page
    public function index()
    {
        return view('backend.seo.index');
    }

     public function updateSeo(Request $request)
    {
        $request->validate([
            // URLs
            'old_url'          => 'nullable|url|max:500',
            'new_url'          => 'nullable|url|max:500',
            'canonical_url'    => 'nullable|url|max:500',
            'redirect_type'    => 'required|in:301,302',
            'index_status'     => 'required|in:index,noindex',
 
            // Meta
            'page_title'       => 'nullable|string|max:70',
            'meta_title'       => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords'    => 'nullable|string|max:500',
            'h1_tag'           => 'nullable|string|max:200',
 
            // Open Graph
            'og_title'         => 'nullable|string|max:60',
            'og_description'   => 'nullable|string|max:200',
            'og_image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
 
            // Twitter
            'twitter_title'       => 'nullable|string|max:60',
            'twitter_description' => 'nullable|string|max:200',
            'twitter_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
 
            // Schema / Notes
            'schema_markup'    => ['nullable', 'string', function ($attr, $val, $fail) {
                if ($val && ! $this->isValidJson($val)) {
                    $fail('Schema markup must be valid JSON-LD.');
                }
            }],
            'seo_notes'        => 'nullable|string|max:2000',
        ]);
 
        $record = Seo::firstOrNew([]);
 
        $record->fill($request->only([
            'old_url', 'new_url', 'canonical_url', 'redirect_type', 'index_status',
            'page_title', 'meta_title', 'meta_description', 'meta_keywords', 'h1_tag',
            'og_title', 'og_description',
            'twitter_title', 'twitter_description',
            'schema_markup', 'seo_notes',
        ]));
 
        // OG Image
        if ($request->hasFile('og_image')) {
            if ($record->og_image) Storage::disk('public')->delete($record->og_image);
            $record->og_image = $request->file('og_image')->store('seo', 'public');
        }
 
        // Twitter Image
        if ($request->hasFile('twitter_image')) {
            if ($record->twitter_image) Storage::disk('public')->delete($record->twitter_image);
            $record->twitter_image = $request->file('twitter_image')->store('seo', 'public');
        }
 
        $record->save();
 
        return response()->json([
            'success' => true,
            'message' => 'SEO settings saved successfully.',
        ]);
    }

    private function isValidJson(string $string): bool
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
 
}
