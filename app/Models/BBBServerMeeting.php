<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BBBServerMeeting extends Model
{
    protected $table = 'server_meetings';
    public $timestamps = false;
    protected $fillable = [
        'server_id',
        'meeting_id',
        'meeting_name',
        'status',
        'start_time'
    ];

    public function server() {
        return $this->belongsTo('App\Models\BBBServerInfo');
    }
}
