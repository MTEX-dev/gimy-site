<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'domain',
        'github_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function siteFiles()
    {
        return $this->hasMany(SiteFile::class);
    }
    
    public function files()
    {
        return $this->siteFiles();
    }

    public function siteDeployments()
    {
        return $this->hasMany(SiteDeployment::class);
    }
}
