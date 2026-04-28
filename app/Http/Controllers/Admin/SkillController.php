<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::withCount('categories')->orderBy('order')->paginate(10);
        return view('admin.skills.index', compact('skills'));
    }
    
    public function create()
    {
        return view('admin.skills.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'icon' => 'nullable|string',
            'color' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        
        Skill::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'icon' => $request->icon,
            'color' => $request->color ?? '#FF6F00',
            'is_active' => $request->has('is_active'),
            'order' => $request->order ?? 0,
        ]);
        
        return redirect()->route('admin.skills.index')->with('success', 'Skill created successfully.');
    }
    
    public function edit(Skill $skill)
    {
        return view('admin.skills.edit', compact('skill'));
    }
    
    public function update(Request $request, Skill $skill)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'icon' => 'nullable|string',
            'color' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        
        $skill->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'icon' => $request->icon,
            'color' => $request->color ?? '#FF6F00',
            'is_active' => $request->has('is_active'),
            'order' => $request->order ?? 0,
        ]);
        
        return redirect()->route('admin.skills.index')->with('success', 'Skill updated successfully.');
    }
    
    public function destroy(Skill $skill)
    {
        $skill->delete();
        return redirect()->route('admin.skills.index')->with('success', 'Skill deleted successfully.');
    }
}