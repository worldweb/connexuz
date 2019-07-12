<?php

namespace App\Models\Network;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

class Network extends Model {

    protected $table = 'user_invites';
    protected $fillable = ['user_id', 'invite_user_id', 'invite_email', 'type', 'status', 'created_at', 'updated_at'];

    

}
