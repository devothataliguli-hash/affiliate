<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SkillController extends Controller
{
    // ==================== SKILL METHODS ====================

    public function index()
    {
        $skills     = Skill::with('category')->latest()->paginate(10);
        $categories = Category::where('is_active', true)->get();
        return view('admin.skills.index', compact('skills', 'categories'));
    }

    /**
     * JSON list for the skills table (AJAX pagination + search).
     * Route: GET /admin/skills-json
     */
    public function indexJson(Request $request)
    {
        $query = Skill::with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('category', fn ($c) => $c->where('name', 'like', "%{$search}%"));
            });
        }

        $skills = $query->latest()->paginate(10);
        return response()->json($skills);
    }

    /**
     * BUG FIX: Renamed from show() → editJson() to avoid clashing with the
     * resource route GET /admin/skills/{skill} (which returns the view).
     * Route: GET /admin/skills/{skill}/edit-json
     */
    public function editJson(Skill $skill)
    {
        return response()->json($skill->load('category'));
    }

    /**
     * Store a new skill.
     * Route: POST /admin/skills
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'description'   => 'nullable|string',
            'price'         => 'required|numeric|min:0',
            'platform_link' => 'nullable|url',
            'video_url'     => 'nullable|url',
            'video_file'    => 'nullable|file|mimes:mp4,mov,avi|max:20480',
            'pdf_file'      => 'nullable|file|mimes:pdf|max:10240',
            'voice_file'    => 'nullable|file|mimes:mp3,wav,ogg|max:15360',
            'notes'         => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();
        $this->handleSkillUploads($request, $validated);

        // BUG FIX: is_active comes as "1"/"0" string from FormData; cast properly
        $validated['is_active'] = filter_var($request->input('is_active', 0), FILTER_VALIDATE_BOOLEAN);

        $skill = Skill::create($validated);
        return response()->json(['success' => true, 'data' => $skill->load('category')]);
    }

    /**
     * Update an existing skill.
     * Route: PUT /admin/skills/{skill}  (sent as POST with _method=PUT)
     */
    public function update(Request $request, Skill $skill)
    {
        $validator = validator($request->all(), [
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'description'   => 'nullable|string',
            'price'         => 'required|numeric|min:0',
            'platform_link' => 'nullable|url',
            'video_url'     => 'nullable|url',
            'video_file'    => 'nullable|file|mimes:mp4,mov,avi|max:20480',
            'pdf_file'      => 'nullable|file|mimes:pdf|max:10240',
            'voice_file'    => 'nullable|file|mimes:mp3,wav,ogg|max:15360',
            'notes'         => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();
        $this->handleSkillUploads($request, $validated, $skill);

        // BUG FIX: same is_active cast fix
        $validated['is_active'] = filter_var($request->input('is_active', 0), FILTER_VALIDATE_BOOLEAN);

        $skill->update($validated);
        return response()->json(['success' => true, 'data' => $skill->fresh('category')]);
    }

    /**
     * Delete a skill and its uploaded files.
     * Route: DELETE /admin/skills/{skill}
     */
    public function destroy(Skill $skill)
    {
        $this->deleteSkillFiles($skill);
        $skill->delete();
        return response()->json(['success' => true]);
    }

    // ==================== CATEGORY METHODS ====================

    /**
     * Return all active categories for the dropdown.
     * Route: GET /admin/categories/all
     */
    public function allCategories()
    {
        // BUG FIX: return ALL categories (not just active) so the Categories tab shows everything
        $categories = Category::latest()->get();
        return response()->json($categories);
    }

    /**
     * Store a new category.
     * Route: POST /admin/categories
     */
    public function storeCategory(Request $request)
    {
        $validator = validator($request->all(), [
            'name'        => 'required|string|max:100|unique:categories,name',
            'description' => 'nullable|string',
            'is_active'   => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $category = Category::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            // BUG FIX: is_active arrives as "1"/"0" string; cast to bool
            'is_active'   => filter_var($request->input('is_active', 1), FILTER_VALIDATE_BOOLEAN),
        ]);

        return response()->json(['success' => true, 'data' => $category]);
    }

    /**
     * Update an existing category.
     * Route: PUT /admin/categories/{category}  (sent as POST with _method=PUT)
     */
    public function updateCategory(Request $request, Category $category)
    {
        $validator = validator($request->all(), [
            'name'        => 'required|string|max:100|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'is_active'   => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $category->update([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            // BUG FIX: same cast
            'is_active'   => filter_var($request->input('is_active', 1), FILTER_VALIDATE_BOOLEAN),
        ]);

        return response()->json(['success' => true, 'data' => $category]);
    }

    /**
     * Delete a category (nullify category_id on related skills).
     * Route: DELETE /admin/categories/{category}
     */
    public function destroyCategory(Category $category)
    {
        $category->skills()->update(['category_id' => null]);
        $category->delete();
        return response()->json(['success' => true]);
    }

    // ==================== PRIVATE HELPERS ====================

    private function handleSkillUploads(Request $request, array &$data, ?Skill $skill = null): void
    {
        if ($request->hasFile('video_file')) {
            // Delete old local file if it exists
            if ($skill && $skill->video_url && !filter_var($skill->video_url, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $skill->video_url));
            }
            $path = $request->file('video_file')->store('skills/videos', 'public');
            $data['video_url'] = Storage::url($path);
        }

        if ($request->hasFile('pdf_file')) {
            if ($skill && $skill->pdf_file) {
                Storage::disk('public')->delete($skill->pdf_file);
            }
            $data['pdf_file'] = $request->file('pdf_file')->store('skills/pdfs', 'public');
        }

        if ($request->hasFile('voice_file')) {
            if ($skill && $skill->voice_file) {
                Storage::disk('public')->delete($skill->voice_file);
            }
            $data['voice_file'] = $request->file('voice_file')->store('skills/audio', 'public');
        }
    }

    private function deleteSkillFiles(Skill $skill): void
    {
        if ($skill->video_url && !filter_var($skill->video_url, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $skill->video_url));
        }
        if ($skill->pdf_file) {
            Storage::disk('public')->delete($skill->pdf_file);
        }
        if ($skill->voice_file) {
            Storage::disk('public')->delete($skill->voice_file);
        }
    }
}