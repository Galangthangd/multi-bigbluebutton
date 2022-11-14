<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BBBServerInfo extends Model
{
    protected $table = "servers";
    protected $fillable = [
        'base_url',
        'sec_secret',
        'weight',
        'enabled',
        'created_at',
        'updated_at'
    ];

    public function serverMeetings() {
        return $this->hasMany('App\Models\BBBServerMeeting');
    }

}
