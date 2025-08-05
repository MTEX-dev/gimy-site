<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteView extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'device_id',
        'ip_address',
        'viewed_at',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}