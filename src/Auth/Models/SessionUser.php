<?php


namespace Common\Auth\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticated;
use Illuminate\Notifications\Notifiable;

class SessionUser extends Authenticated
{
    use HasFactory, Notifiable;

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
        'avatar',
        'phone',
        'jti'
    ];

    public function getAuthIdentifierName(){
        if(array_key_exists('jwt',$this->toArray())){
            return 'jwt';
        }
        return parent::getAuthIdentifierName();
    }
}
