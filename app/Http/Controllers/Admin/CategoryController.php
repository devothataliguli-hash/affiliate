<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Skill $skill)
    {
        $categories = $skill->categories()->orderBy('order')->get();
        return view('admin.categories.index', compact('skill', 'categories'));
    }

    public function create(Skill $skill)
    {
        return view('admin.categories.create', compact('skill'));
    }

    public function store(Request $request, Skill $skill)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        // Generate base slug
        $slug = Str::slug($request->name);

        // Make slug unique globally
        $slug = $this->uniqueSlug($slug);

        $skill->categories()->create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'order' => $request->order ?? 0,
        ]);

        return redirect()
            ->route('admin.skills.categories.index', $skill)
            ->with('success', 'Category created successfully.');
    }

    /**
     * FIXED: Add Skill parameter before Category
     * Route: admin/skills/{skill}/categories/{category}/edit
     */
    public function edit(Skill $skill, Category $category)
    {
        // Verify the category belongs to this skill
        if ($category->skill_id !== $skill->id) {
            abort(404, 'Category not found for this skill.');
        }
        
        return view('admin.categories.edit', compact('skill', 'category'));
    }

    /**
     * FIXED: Add Skill parameter before Category
     */
    public function update(Request $request, Skill $skill, Category $category)
    {
        // Verify the category belongs to this skill
        if ($category->skill_id !== $skill->id) {
            abort(404, 'Category not found for this skill.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $slug = Str::slug($request->name);

        // Only regenerate slug if name changed
        if ($category->name !== $request->name) {
            $slug = $this->uniqueSlug($slug);
        }

        $category->update([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'order' => $request->order ?? 0,
        ]);

        return redirect()
            ->route('admin.skills.categories.index', $skill)
            ->with('success', 'Category updated successfully.');
    }

    /**
     * FIXED: Add Skill parameter before Category
     */
    public function destroy(Skill $skill, Category $category)
    {
        // Verify the category belongs to this skill
        if ($category->skill_id !== $skill->id) {
            abort(404, 'Category not found for this skill.');
        }
        
        $category->delete();

        return redirect()
            ->route('admin.skills.categories.index', $skill)
            ->with('success', 'Category deleted successfully.');
    }

    /**
     * Ensure slug is unique in categories table
     */
    private function uniqueSlug($slug)
    {
        $original = $slug;
        $count = 1;

        while (Category::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $count++;
        }

        return $slug;
    }
}