<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteExport extends Model
{

    protected $guarded = ['id'];

    public function site(){
        return $this->belongsTo(Site::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
