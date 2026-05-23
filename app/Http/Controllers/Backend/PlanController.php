<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\FeesCategory;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::with('category')->orderBy('sort_order')->get();
        return view('backend.feessection.index', compact('plans'));
    }
    // Create
    public function create()
    {
        $categories = FeesCategory::all();
        return view('backend.feessection.create', compact('categories'));
    }
    // Store
    public function store(Request $request)
    {
        // return $request;
        // Ensure features is always an array before validation (missing key = empty array)
        if (! $request->has('features')) {
            $request->merge(['features' => []]);
        }

        // billing_interval comes as both a disabled select + hidden input — keep only one value
        $request->merge(['billing_interval' => 'month']);

        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'category_id'       => 'required|exists:fees_categories,id',
            'country_code'      => 'required|string|size:2',
            'duration'          => 'required|in:30_minutes,1_hour',
            'days_per_week'     => 'required|integer|min:1|max:7',
            'monthly_price'     => 'required|numeric|min:0',
            'currency'          => 'required|string|size:3',
            'billing_interval'  => 'required|in:month',
            'subtitle'          => 'nullable|string|max:255',
            'description'       => 'nullable|string',   
            'features' => 'nullable|string', 
           
            'badge'             => 'nullable|string|max:50',
            'button_text'       => 'nullable|string|max:100',
            'stripe_price_id'   => 'required|string|unique:plans,stripe_price_id',
            'stripe_product_id' => 'nullable|string|max:255',
            'is_active'         => 'required|boolean',
            'sort_order'        => 'nullable|integer|min:0',
        ], [
            'name.required'            => 'Plan name is required.',
            'category_id.required'     => 'Please select a category.',
            'category_id.exists'       => 'Selected category does not exist.',
            'duration.required'        => 'Please select a duration.',
            'duration.in'              => 'Duration must be 30 minutes or 1 hour.',
            'days_per_week.required'   => 'Please select the number of days per week.',
            'days_per_week.min'        => 'Days per week must be at least 1.',
            'days_per_week.max'        => 'Days per week cannot exceed 7.',
            'monthly_price.required'   => 'Monthly price is required.',
            'monthly_price.numeric'    => 'Monthly price must be a valid number.',
            'monthly_price.min'        => 'Monthly price cannot be negative.',
            'stripe_price_id.required' => 'Stripe price ID is required.',
            'stripe_price_id.unique'   => 'This Stripe price ID is already in use.',
        ]);

        // Check composite unique constraint: country_code + duration + days_per_week
        $duplicate = Plan::where('country_code',  $validated['country_code'])
                            ->where('duration',      $validated['duration'])
                            ->where('days_per_week', $validated['days_per_week'])
                            ->exists();

        if ($duplicate) {
            return back()
                ->withInput()
                ->withErrors([
                    'days_per_week' => 'A plan with this country, duration, and days per week combination already exists.',
                ]);
        }

        // Normalise optional fields
        $validated['button_text'] = $validated['button_text'] ?? 'Choose Plan';
        $validated['sort_order']  = $validated['sort_order']  ?? 0;
// ✅ Correct — decode the JSON string first
$validated['features'] = !empty($validated['features'])
                            ? array_values(array_filter(json_decode($validated['features'], true)))
                            : null;

        // Plan::create($validated);
Plan::create($validated);

return response()->json([
    'success'  => true,
    'message'  => 'Plan created successfully!',
    'redirect' => route('admin.plans.index'), // or wherever you want
]);
            
    }
    // Edit
    public function edit($id)
    {
        $edit = Plan::findOrFail($id);
       
        $categories = FeesCategory::all();
        return view('backend.feessection.update', compact('edit', 'categories'));
    }
    // Update
    public function update(Request $request, $id){

         return $request;
        // Ensure features is always an array before validation (missing key = empty array)
        if (! $request->has('features')) {
            $request->merge(['features' => []]);
        }

        // billing_interval comes as both a disabled select + hidden input — keep only one value
        $request->merge(['billing_interval' => 'month']);

        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'category_id'       => 'required|exists:fees_categories,id',
            'country_code'      => 'required|string|size:2',
            'duration'          => 'required|in:30_minutes,1_hour',
            'days_per_week'     => 'required|integer|min:1|max:7',
            'monthly_price'     => 'required|numeric|min:0',
            'currency'          => 'required|string|size:3',
            'billing_interval'  => 'required|in:month',
            'subtitle'          => 'nullable|string|max:255',
            'description'       => 'nullable|string',   
            'features'          => 'nullable|string|max:255',
            'badge'             => 'nullable|string|max:50',
            'button_text'       => 'nullable|string|max:100',
            'stripe_product_id' => 'nullable|string|max:255',
            'is_active'         => 'required|boolean',
            'sort_order'        => 'nullable|integer|min:0',
        ], [
            'name.required'            => 'Plan name is required.',
            'category_id.required'     => 'Please select a category.',
            'category_id.exists'       => 'Selected category does not exist.',
            'duration.required'        => 'Please select a duration.',
            'duration.in'              => 'Duration must be 30 minutes or 1 hour.',
            'days_per_week.required'   => 'Please select the number of days per week.',
            'days_per_week.min'        => 'Days per week must be at least 1.',
            'days_per_week.max'        => 'Days per week cannot exceed 7.',
            'monthly_price.required'   => 'Monthly price is required.',
            'monthly_price.numeric'    => 'Monthly price must be a valid number.',
            'monthly_price.min'        => 'Monthly price cannot be negative.',
            'stripe_price_id.required' => 'Stripe price ID is required.',
            'stripe_price_id.unique'   => 'This Stripe price ID is already in use.',
        ]);

        // Check composite unique constraint: country_code + duration + days_per_week
        $duplicate = Plan::where('country_code',  $validated['country_code'])
                            ->where('duration',      $validated['duration'])
                            ->where('days_per_week', $validated['days_per_week'])
                            ->exists();

        if ($duplicate) {
            return back()
                ->withInput()
                ->withErrors([
                    'days_per_week' => 'A plan with this country, duration, and days per week combination already exists.',
                ]);
        }

       
        $validated['button_text'] = $validated['button_text'] ?? 'Choose Plan';
        $validated['sort_order']  = $validated['sort_order']  ?? 0;

        $validated['stripe_price_id'] = "required|string|unique:plans,stripe_price_id,{$id}";
        $plan->update($validated);
        return response()->json(['success' => true, 'message' => 'Plan updated successfully!']);
    }
}
