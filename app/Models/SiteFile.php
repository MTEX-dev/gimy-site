<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteFile extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'site_id',
        'path',
        'content',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
