<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SeoController extends Controller
{
    // index page
    public function index()
    {
        return view('backend.seo.index');
    }

     public function updateSeo(Request $request)
    {
        
    
 
        $record = Seo::where('id', 1)->update([

            'old_url'          => $request->old_url,
            'new_url'          => $request->new_url,
            'canonical_url'    => $request->canonical_url,
            'redirect_type'    => $request->redirect_type,
            'index_status'     => $request->index_status,
 
            'page_title'       => $request->page_title,
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords'    => $request->meta_keywords,
            'h1_tag'           => $request->h1_tag,
 
            'og_title'         => $request->og_title,
            'og_description'   => $request->og_description,
 
            'twitter_title'       => $request->twitter_title,
            'twitter_description' => $request->twitter_description,
            'schema_markup'       => $request->schema_markup,
            'seo_notes'          => $request->seo_notes,
            'updated_at'          => now(),
        ]);
 
      
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
