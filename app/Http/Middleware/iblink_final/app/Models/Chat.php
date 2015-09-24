<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Chat extends Model {

	protected $table = 'chats';
	protected $fillable = [
		'send_by',
		'send_to',
		'read',
		'seen',
		'message',
		'send_at_time'];


	public function from() {
        return $this->belongsTo('\App\Models\User', 'send_by');
    }

	public function to() {
        return $this->belongsTo('\App\Models\User', 'send_to');
    }

}
