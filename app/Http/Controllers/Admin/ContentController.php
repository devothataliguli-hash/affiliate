<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    public function index(Category $category)
    {
        $contents = $category->contents()->orderBy('order')->get();
        return view('admin.contents.index', compact('category', 'contents'));
    }

    public function create(Category $category)
    {
        return view('admin.contents.create', compact('category'));
    }

    public function store(Request $request, Category $category)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:video,audio,pdf,text',
            'is_free_preview' => 'boolean',
            'file' => 'nullable|file|max:200000',
            'video_url' => 'nullable|url',
        ]);

        $data = [
            'title' => $request->title,
            'type' => $request->type,
            'is_free_preview' => $request->has('is_free_preview'),
            'order' => $request->order ?? 0,
            'duration' => $request->duration,
            'file_path' => null,
            'video_url' => null,
            'audio_url' => null,
            'pdf_url' => null,
            'text_content' => null,
        ];

        // ================= VIDEO =================
        if ($request->type === 'video') {

            if ($request->hasFile('file')) {
                $data['file_path'] = $request->file('file')->store('videos', 'public');
            } else {
                $data['video_url'] = $request->video_url;
            }
        }

        // ================= AUDIO =================
        elseif ($request->type === 'audio') {

            if ($request->hasFile('file')) {
                $data['file_path'] = $request->file('file')->store('audios', 'public');
            } else {
                $data['audio_url'] = $request->audio_url;
            }
        }

        // ================= PDF =================
        elseif ($request->type === 'pdf') {

            if ($request->hasFile('file')) {
                $data['file_path'] = $request->file('file')->store('pdfs', 'public');
            } else {
                $data['pdf_url'] = $request->pdf_url;
            }
        }

        // ================= TEXT =================
        elseif ($request->type === 'text') {
            $data['text_content'] = $request->text_content;
        }

        $category->contents()->create($data);

        return redirect()
            ->route('admin.categories.contents.index', $category)
            ->with('success', 'Content added successfully.');
    }

    public function edit(Category $category, Content $content)
    {
        if ($content->category_id !== $category->id) {
            abort(404);
        }

        return view('admin.contents.edit', compact('category', 'content'));
    }

    public function update(Request $request, Category $category, Content $content)
    {
        if ($content->category_id !== $category->id) {
            abort(404);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:video,audio,pdf,text',
            'is_free_preview' => 'boolean',
            'file' => 'nullable|file|max:200000',
            'video_url' => 'nullable|url',
        ]);

        $data = [
            'title' => $request->title,
            'type' => $request->type,
            'is_free_preview' => $request->has('is_free_preview'),
            'order' => $request->order ?? 0,
            'duration' => $request->duration,
        ];

        // ================= VIDEO =================
        if ($request->type === 'video') {

            if ($request->hasFile('file')) {

                if ($content->file_path) {
                    Storage::disk('public')->delete($content->file_path);
                }

                $data['file_path'] = $request->file('file')->store('videos', 'public');
                $data['video_url'] = null;

            } else {
                $data['video_url'] = $request->video_url;
            }
        }

        // ================= AUDIO =================
        elseif ($request->type === 'audio') {

            if ($request->hasFile('file')) {

                if ($content->file_path) {
                    Storage::disk('public')->delete($content->file_path);
                }

                $data['file_path'] = $request->file('file')->store('audios', 'public');
                $data['audio_url'] = null;

            } else {
                $data['audio_url'] = $request->audio_url;
            }
        }

        // ================= PDF =================
        elseif ($request->type === 'pdf') {

            if ($request->hasFile('file')) {

                if ($content->file_path) {
                    Storage::disk('public')->delete($content->file_path);
                }

                $data['file_path'] = $request->file('file')->store('pdfs', 'public');
                $data['pdf_url'] = null;

            } else {
                $data['pdf_url'] = $request->pdf_url;
            }
        }

        // ================= TEXT =================
        elseif ($request->type === 'text') {
            $data['text_content'] = $request->text_content;
        }

        $content->update($data);

        return redirect()
            ->route('admin.categories.contents.index', $category)
            ->with('success', 'Content updated successfully.');
    }

    public function destroy(Content $content)
    {
        if ($content->file_path) {
            Storage::disk('public')->delete($content->file_path);
        }

        $category = $content->category;
        $content->delete();

        return redirect()
            ->route('admin.categories.contents.index', $category)
            ->with('success', 'Content deleted successfully.');
    }
}