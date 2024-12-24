<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use HasFactory;
class MailBox extends Model
{
    
    protected $table = 'mail_box';
    
    protected $fillable = ['sender_id', 'receiver_id', 'message'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
