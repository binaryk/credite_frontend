<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrator extends Model {

    protected $table = "administrators";

    protected $fillable = [
        'firstname', 'lastname', 'phone', 'address',
        'cnp', 'image'
    ];

    public $timestamps = false;

    public static function getStaticMorphClass() {
        return 'admin';
    }

    public function __construct(array $attributes = []) {
        $this->morphClass = self::getStaticMorphClass();
        parent::__construct($attributes);
    }

    protected $morphClass = 'admin';

    public function user() {
        return $this->morphOne('App\Models\User', 'userable');
    }

    public function getRoleTitle() {
        return 'Administrator';
    }

}
