<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Page extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'site_id',
        'slug',
        'title',
        'html_content',
        'is_homepage',
    ];

    protected $casts = [
        'is_homepage' => 'boolean',
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function assets(): BelongsToMany
    {
        return $this->belongsToMany(Asset::class);
    }

    public function getUrlAttribute(): string
    {
        return $this->site->baseUrl . '/' . ($this->is_homepage ? '' : $this->slug);
    }
}