<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::latest()->paginate(10);
        return view('admin.skills.index', compact('skills'));
    }

    public function create()
    {
        return view('admin.skills.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'video_url' => 'nullable|url',
            'video_file' => 'nullable|file|mimes:mp4,mov,avi|max:20480',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('video_file')) {
            $path = $request->file('video_file')->store('skills/videos', 'public');
            $validated['video_url'] = Storage::url($path);
        }

        Skill::create($validated);

        return redirect()->route('admin.skills.index')->with('success', 'Skill imeongezwa kikamilifu!');
    }

    public function edit(Skill $skill)
    {
        return view('admin.skills.edit', compact('skill'));
    }

    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'video_url' => 'nullable|url',
            'video_file' => 'nullable|file|mimes:mp4,mov,avi|max:20480',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('video_file')) {
            // Delete old video if exists
            if ($skill->video_url && Storage::disk('public')->exists(str_replace('/storage/', '', $skill->video_url))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $skill->video_url));
            }
            $path = $request->file('video_file')->store('skills/videos', 'public');
            $validated['video_url'] = Storage::url($path);
        }

        $validated['is_active'] = $request->has('is_active');
        $skill->update($validated);

        return redirect()->route('admin.skills.index')->with('success', 'Skill imesasishwa!');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();
        return redirect()->route('admin.skills.index')->with('success', 'Skill imefutwa.');
    }
}