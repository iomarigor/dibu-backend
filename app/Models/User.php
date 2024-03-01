<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable;
    protected $table = 'users';
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 
        'username', 
        'full_name', 
        'email', 
        'password', 
        'ip_address', 
        'id_level_user', 
        'last_user', 
        'status_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'email_verified_at',
        'ip_address',
        'remember_token',
        'last_user'
    ];
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function status()
    {
        return $this->belongsTo(StatusData::class, 'status_id');
    }

    public static function allDA()
    {
        return self::whereIn('status_id', [3, 2])->get();
    }


    public static function allall()
    {
        return self::all();
    }

    public static function findDA($id)
    {
        return self::whereIn('status_id', [2, 3])->find($id);
    }

    public function delete()
    {
        // Cambia el estado a "Eliminado" en lugar de eliminar el registro
        $this->status_id = 1;
        $this->save();
    }
}
