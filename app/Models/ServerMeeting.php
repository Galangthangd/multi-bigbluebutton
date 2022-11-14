<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServerMeeting extends Model
{
    protected $fillable = [
        'server_id',
        'meeting_id',
        'meeting_name',
        'status',
        'start_time',
    
    ];
    
    
    protected $dates = [
        'start_time',
    
    ];
    public $timestamps = false;
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/server-meetings/'.$this->getKey());
    }
}
