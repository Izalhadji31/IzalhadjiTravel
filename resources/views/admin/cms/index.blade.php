@extends('layouts.app')

@section('title', 'CMS Pages')

@section('content')
<div class="page-header">
    <h1 class="page-title">CMS Pages</h1>
    <p class="page-subtitle">Manage static pages and content</p>
</div>

<!-- Filters -->
<div class="card" style="margin-bottom: 1.5rem;">
    <form method="GET" action="{{ route('cms.index') }}" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: flex-end;">
        <div>
            <label class="form-label">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" class="form-input" placeholder="Title or slug..." style="width: 200px;">
        </div>
        <div>
            <label class="form-label">Type</label>
            <select name="type" class="form-input" style="width: 150px;">
                <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>All Types</option>
                @foreach($types as $type)
                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="form-label">Status</label>
            <select name="status" class="form-input" style="width: 150px;">
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All</option>
                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('cms.create') }}" class="btn btn-primary" style="margin-left: auto;">+ New Page</a>
    </form>
</div>

<!-- Pages Table -->
<div class="card" style="padding: 0; overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; font-size: 0.85rem; color: #666;">Title</th>
                <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; font-size: 0.85rem; color: #666;">Slug</th>
                <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; font-size: 0.85rem; color: #666;">Type</th>
                <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; font-size: 0.85rem; color: #666;">Status</th>
                <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; font-size: 0.85rem; color: #666;">Updated</th>
                <th style="padding: 0.75rem 1rem; text-align: right; font-weight: 600; font-size: 0.85rem; color: #666;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pages as $page)
            <tr style="border-bottom: 1px solid #f3f4f6;">
                <td style="padding: 0.75rem 1rem; font-weight: 500;">{{ $page->title }}</td>
                <td style="padding: 0.75rem 1rem; color: #666; font-size: 0.9rem;">/{{ $page->slug }}</td>
                <td style="padding: 0.75rem 1rem;">
                    <span style="padding: 0.25rem 0.5rem; background: #e0e7ff; color: #3730a3; border-radius: 0.25rem; font-size: 0.8rem;">{{ ucfirst($page->type) }}</span>
                </td>
                <td style="padding: 0.75rem 1rem;">
                    @if($page->is_published)
                        <span style="color: #059669; font-weight: 500;">● Published</span>
                    @else
                        <span style="color: #d97706; font-weight: 500;">● Draft</span>
                    @endif
                </td>
                <td style="padding: 0.75rem 1rem; color: #666; font-size: 0.9rem;">{{ $page->updated_at->format('d M Y') }}</td>
                <td style="padding: 0.75rem 1rem; text-align: right;">
                    <a href="{{ route('cms.edit', $page) }}" style="color: #2563eb; text-decoration: none; margin-right: 0.75rem;">Edit</a>
                    <form method="POST" action="{{ route('cms.destroy', $page) }}" style="display: inline;" onsubmit="return confirm('Delete this page?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="color: #ef4444; background: none; border: none; cursor: pointer;">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="padding: 2rem; text-align: center; color: #999;">No pages found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div style="margin-top: 1.5rem;">
    {{ $pages->links() }}
</div>
@endsection
