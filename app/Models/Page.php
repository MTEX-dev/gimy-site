<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Page extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'site_id',
        'title',
        'slug',
        'html',
        'css',
        'js',
        'is_homepage',
    ];

    protected function casts(): array
    {
        return [
            'is_homepage' => 'boolean',
        ];
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }
}