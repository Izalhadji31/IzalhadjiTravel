@extends('layouts.app')

@section('title', 'Edit CMS Page')

@section('content')
<div class="page-header">
    <h1 class="page-title">Edit CMS Page</h1>
    <p class="page-subtitle">{{ $cmsPage->title }}</p>
</div>

<div class="card" style="max-width: 900px;">
    <form method="POST" action="{{ route('admin.cms.update', $cmsPage) }}">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
            <div>
                <label class="form-label" for="title">Title *</label>
                <input type="text" id="title" name="title" value="{{ old('title', $cmsPage->title) }}" class="form-input" required>
                @error('title')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label class="form-label" for="slug">Slug</label>
                <input type="text" id="slug" name="slug" value="{{ old('slug', $cmsPage->slug) }}" class="form-input">
                @error('slug')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
            <div>
                <label class="form-label" for="type">Type *</label>
                <select id="type" name="type" class="form-input" required>
                    <option value="about" {{ old('type', $cmsPage->type) == 'about' ? 'selected' : '' }}>About</option>
                    <option value="testimonial" {{ old('type', $cmsPage->type) == 'testimonial' ? 'selected' : '' }}>Testimonial</option>
                    <option value="faq" {{ old('type', $cmsPage->type) == 'faq' ? 'selected' : '' }}>FAQ</option>
                    <option value="banner" {{ old('type', $cmsPage->type) == 'banner' ? 'selected' : '' }}>Banner</option>
                    <option value="contact" {{ old('type', $cmsPage->type) == 'contact' ? 'selected' : '' }}>Contact</option>
                    <option value="other" {{ old('type', $cmsPage->type) == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('type')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label class="form-label" for="order">Order</label>
                <input type="number" id="order" name="order" value="{{ old('order', $cmsPage->order) }}" class="form-input" min="0">
                @error('order')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label class="form-label" for="image_url">Image URL</label>
                <input type="url" id="image_url" name="image_url" value="{{ old('image_url', $cmsPage->image_url) }}" class="form-input" placeholder="https://...">
                @error('image_url')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div style="margin-bottom: 1rem;">
            <label class="form-label" for="excerpt">Excerpt</label>
            <textarea id="excerpt" name="excerpt" class="form-input" rows="2" placeholder="Short summary...">{{ old('excerpt', $cmsPage->excerpt) }}</textarea>
            @error('excerpt')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 1rem;">
            <label class="form-label" for="content">Content *</label>
            <div style="border: 1px solid #e5e7eb; border-radius: 0.5rem; overflow: hidden;">
                <!-- Simple WYSIWYG Toolbar -->
                <div style="background: #f9fafb; border-bottom: 1px solid #e5e7eb; padding: 0.5rem; display: flex; gap: 0.25rem; flex-wrap: wrap;">
                    <button type="button" onclick="formatDoc('bold')" style="padding: 0.25rem 0.5rem; background: white; border: 1px solid #d1d5db; border-radius: 0.25rem; cursor: pointer; font-weight: bold;" title="Bold">B</button>
                    <button type="button" onclick="formatDoc('italic')" style="padding: 0.25rem 0.5rem; background: white; border: 1px solid #d1d5db; border-radius: 0.25rem; cursor: pointer; font-style: italic;" title="Italic">I</button>
                    <button type="button" onclick="formatDoc('underline')" style="padding: 0.25rem 0.5rem; background: white; border: 1px solid #d1d5db; border-radius: 0.25rem; cursor: pointer; text-decoration: underline;" title="Underline">U</button>
                    <button type="button" onclick="formatDoc('insertUnorderedList')" style="padding: 0.25rem 0.5rem; background: white; border: 1px solid #d1d5db; border-radius: 0.25rem; cursor: pointer;" title="Bullet List">• List</button>
                    <button type="button" onclick="formatDoc('insertOrderedList')" style="padding: 0.25rem 0.5rem; background: white; border: 1px solid #d1d5db; border-radius: 0.25rem; cursor: pointer;" title="Numbered List">1. List</button>
                    <button type="button" onclick="formatDoc('formatBlock', 'h2')" style="padding: 0.25rem 0.5rem; background: white; border: 1px solid #d1d5db; border-radius: 0.25rem; cursor: pointer;" title="Heading">H2</button>
                    <button type="button" onclick="formatDoc('formatBlock', 'p')" style="padding: 0.25rem 0.5rem; background: white; border: 1px solid #d1d5db; border-radius: 0.25rem; cursor: pointer;" title="Paragraph">¶</button>
                </div>
                <div id="editor" contenteditable="true" style="min-height: 300px; padding: 1rem; outline: none; font-size: 0.95rem; line-height: 1.6;"> {!! $cmsPage->content !!}</div>
            </div>
            <textarea id="content" name="content" style="display: none;"> {!! $cmsPage->content !!}</textarea>
            @error('content')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label class="checkbox-group">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $cmsPage->is_published) ? 'checked' : '' }}>
                <label for="is_published">Published</label>
            </label>
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Update Page</button>
            <a href="{{ route('admin.cms.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script>
    function formatDoc(command, value = null) {
        document.execCommand(command, false, value);
        document.getElementById('editor').focus();
    }

    // Sync editor content to textarea on form submit
    document.querySelector('form').addEventListener('submit', function() {
        document.getElementById('content').value = document.getElementById('editor').innerHTML;
    });
</script>
@endsection
