<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteRequest extends Model
{
    use HasFactory;

    // protected $table = 'site_requests';
    
    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function extension()
    {
        return $this->belongsTo(Extension::class);
    }
}
