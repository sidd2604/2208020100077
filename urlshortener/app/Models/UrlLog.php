<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UrlLog extends Model
{
     protected $fillable = ['url_id', 'clicked_at', 'referrer', 'location'];

    public function url()
    {
        return $this->belongsTo(Url::class);
    }
}
