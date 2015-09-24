<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuperAdministrator extends Model {

    public static function getStaticMorphClass() {
        return 'admin';
    }

    public function __construct(array $attributes = []) {
        $this->morphClass = self::getStaticMorphClass();
        parent::__construct($attributes);
    }

    protected $morphClass = 'superadmin';

    public function user() {
        return $this->morphOne('App\Models\User', 'userable');
    }

    public function getRoleTitle() {
        return 'Super Administrator';
    }

}
