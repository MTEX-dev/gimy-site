<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Asset extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = ['site_id', 'name', 'path', 'mime_type', 'size'];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function pages(): BelongsToMany
    {
        return $this->belongsToMany(Page::class);
    }

    /*
    public function getUrlAttribute(): string
    {
        return $this->site->baseUrl . '/' . $this->path;
    }
    */

    public function getUrlAttribute(): string
    {
        return Storage::disk('public')->url("sites/{$this->site->id}/{$this->path}");
    }
}