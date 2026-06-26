<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CmsPageController extends Controller
{
    /**
     * Display a listing of CMS pages
     */
    public function index(Request $request)
    {
        $query = CmsPage::query();

        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('is_published', $request->status === 'published');
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $pages = $query->latest()->paginate(15)->withQueryString();
        $types = CmsPage::select('type')->distinct()->pluck('type');

        return view('admin.cms.index', compact('pages', 'types'));
    }

    /**
     * Show the form for creating a new CMS page
     */
    public function create()
    {
        return view('admin.cms.create');
    }

    /**
     * Store a newly created CMS page
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:cms_pages,slug',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'image_url' => 'nullable|url|max:500',
            'type' => 'required|in:about,testimonial,faq,banner,contact,other',
            'is_published' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['created_by'] = auth()->id();
        $validated['updated_by'] = auth()->id();
        $validated['is_published'] = $request->boolean('is_published', false);
        $validated['published_at'] = $validated['is_published'] ? now() : null;

        CmsPage::create($validated);

        return redirect()->route('admin.cms.index')
                         ->with('success', 'CMS Page created successfully.');
    }

    /**
     * Display the specified CMS page
     */
    public function show(CmsPage $cmsPage)
    {
        return view('admin.cms.show', compact('cmsPage'));
    }

    /**
     * Show the form for editing the specified CMS page
     */
    public function edit(CmsPage $cmsPage)
    {
        return view('admin.cms.edit', compact('cmsPage'));
    }

    /**
     * Update the specified CMS page
     */
    public function update(Request $request, CmsPage $cmsPage)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:cms_pages,slug,' . $cmsPage->id,
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'image_url' => 'nullable|url|max:500',
            'type' => 'required|in:about,testimonial,faq,banner,contact,other',
            'is_published' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['updated_by'] = auth()->id();
        $validated['is_published'] = $request->boolean('is_published', false);
        
        if ($validated['is_published'] && !$cmsPage->is_published) {
            $validated['published_at'] = now();
        } elseif (!$validated['is_published']) {
            $validated['published_at'] = null;
        }

        $cmsPage->update($validated);

        return redirect()->route('admin.cms.index')
                         ->with('success', 'CMS Page updated successfully.');
    }

    /**
     * Remove the specified CMS page
     */
    public function destroy(CmsPage $cmsPage)
    {
        $cmsPage->delete();

        return redirect()->route('admin.cms.index')
                         ->with('success', 'CMS Page deleted successfully.');
    }
}
