<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    /**
     * Display a listing of testimonials.
     */
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(10);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new testimonial.
     */
    public function create()
    {
        return view('admin.testimonials.create');
    }

    /**
     * Store a newly created testimonial in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'location'   => 'nullable|string|max:255',
            'content'    => 'required|string',
            'image'      => 'nullable|image|max:2048',
            'screenshot' => 'nullable|image|max:2048',
            'rating'     => 'integer|min:1|max:5',
            'is_active'  => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('testimonials', 'public');
        }
        if ($request->hasFile('screenshot')) {
            $validated['screenshot'] = $request->file('screenshot')->store('testimonials/screenshots', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        Testimonial::create($validated);

        return redirect()->route('admin.testimonials.index')
                         ->with('success', 'Ushuhuda umeongezwa!');
    }

    /**
     * Show the form for editing the specified testimonial.
     */
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified testimonial in storage.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'location'   => 'nullable|string|max:255',
            'content'    => 'required|string',
            'image'      => 'nullable|image|max:2048',
            'screenshot' => 'nullable|image|max:2048',
            'rating'     => 'integer|min:1|max:5',
            'is_active'  => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($testimonial->image) {
                Storage::disk('public')->delete($testimonial->image);
            }
            $validated['image'] = $request->file('image')->store('testimonials', 'public');
        }
        if ($request->hasFile('screenshot')) {
            if ($testimonial->screenshot) {
                Storage::disk('public')->delete($testimonial->screenshot);
            }
            $validated['screenshot'] = $request->file('screenshot')->store('testimonials/screenshots', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $testimonial->update($validated);

        return redirect()->route('admin.testimonials.index')
                         ->with('success', 'Ushuhuda umesasishwa!');
    }

    /**
     * Remove the specified testimonial from storage.
     * Supports both AJAX (JSON) and normal form requests.
     */
public function destroy($id)
{
    // Manually find the testimonial, or fail with a JSON response
    $testimonial = Testimonial::find($id);
    
    if (!$testimonial) {
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => false, 'message' => 'Testimonial not found.'], 404);
        }
        return redirect()->route('admin.testimonials.index')->with('error', 'Testimonial not found.');
    }

    // Delete images
    if ($testimonial->image) Storage::disk('public')->delete($testimonial->image);
    if ($testimonial->screenshot) Storage::disk('public')->delete($testimonial->screenshot);
    $testimonial->delete();

    if (request()->ajax() || request()->wantsJson()) {
        return response()->json(['success' => true, 'message' => 'Deleted successfully.']);
    }

    return redirect()->route('admin.testimonials.index')->with('success', 'Ushuhuda umefutwa.');
}
}