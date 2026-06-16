<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CmsPage extends Model
{
    use HasFactory;

    protected $table = 'cms_pages';

    protected $fillable = [
        'slug',
        'title',
        'content',
        'excerpt',
        'image_url',
        'type',
        'is_published',
        'order',
        'created_by',
        'updated_by',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('order');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type)->published();
    }

    public function scopeBySlug($query, $slug)
    {
        return $query->where('slug', $slug)->firstOrFail();
    }
}
