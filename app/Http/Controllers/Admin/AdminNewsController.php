<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminNewsController extends Controller
{
    public function index(): View
    {
        $news = News::firstOrCreate(
            [],
            [
                'title' => 'Welcome to Our Store',
                'content' => 'Check out our latest offers!',
                'is_active' => false
            ]
        );

        return view('admin.news.index', compact('news'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string|max:1000',
            'is_active' => 'nullable|boolean',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,jpg,png,webp,gif|max:2048'
        ], [
            'images.*.image' => 'Each file must be a valid image.',
            'images.*.mimes' => 'Images must be in JPEG, PNG, WEBP, or GIF format.',
            'images.*.max' => 'Each image must not exceed 2MB.',
        ]);

        try {
            $news = News::firstOrFail();
            
            $news->title = $validated['title'] ?? null;
            $news->content = $validated['content'] ?? null;
            $news->is_active = $request->input('is_active', 0) == 1;

            if ($request->hasFile('images')) {
                $existingImages = $news->images ?? [];
                $newImages = [];

                foreach ($request->file('images') as $image) {
                    if ($image->isValid()) {
                        $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                        $path = $image->storeAs('news', $filename, 'public');
                        $newImages[] = $path;
                    }
                }

                $allImages = array_merge($existingImages, $newImages);
                $news->images = array_slice($allImages, 0, 10);
            }

            $news->save();

            return redirect()
                ->route('admin.news.index')
                ->with('success', 'News banner updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to update news banner: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function deleteImage(Request $request): RedirectResponse
    {
        $request->validate([
            'news_id' => 'required|exists:news,id',
            'image_index' => 'required|integer|min:0'
        ]);

        try {
            $news = News::findOrFail($request->news_id);
            $images = $news->images ?? [];

            if (isset($images[$request->image_index])) {
                Storage::disk('public')->delete($images[$request->image_index]);
                unset($images[$request->image_index]);
                $news->images = array_values($images);
                $news->save();

                return redirect()
                    ->route('admin.news.index')
                    ->with('success', 'Image deleted successfully!');
            }

            return redirect()
                ->back()
                ->with('error', 'Image not found.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to delete image: ' . $e->getMessage());
        }
    }

    public function toggleActive(News $news): RedirectResponse
    {
        try {
            $news->is_active = !$news->is_active;
            $news->save();

            $status = $news->is_active ? 'activated' : 'deactivated';

            return redirect()
                ->back()
                ->with('success', "News banner {$status} successfully!");

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to toggle banner status: ' . $e->getMessage());
        }
    }
}