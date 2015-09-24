<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Session;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;

    protected $table = 'users';

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected $types = [
        'superadmin' => 'App\Models\SuperAdministrator',
        'admin'      => 'App\Models\Administrator',
        'teacher'    => 'App\Models\Teacher',
        'student'    => 'App\Models\Student',
        'custodian'  => 'App\Models\Custodian',
    ];

    public function getUserableTypeAttribute($type) {
        return array_get($this->types, $type, $type);
    }

    public function userable() {
        return $this->morphTo();
    }

    public function institutions() {
        return $this->belongsToMany('App\Models\Institution');
    }

    public function getTargetUser() {

        static $target_user = false;

        $student_id  = Session::get('student.user.id');
        $isCustodian = ($this->getOriginal('userable_type') == 'custodian');

        if ($isCustodian && $student_id) {

            if ($target_user && $target_user->id == $student_id) {
                return $target_user;
            }

            return ($target_user = User::find($student_id));
        }

        return $this;
    }

}
