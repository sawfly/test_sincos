<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'invited_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * relation to links
     */
    public function links() {
        return $this->hasMany('App\Link');
    }

    public function withInvitedBy($id) {
        $user = User::leftJoin('users as u', 'u.id', '=', 'users.invited_by')
            ->leftJoin('links', 'users.id', '=', 'links.user_id')
            ->where(['users.id' => $id, 'links.status_id' => 0])->orWhere(['users.id' => $id])
            ->orderBy('links.created_at', 'desc')->limit(1)
            ->get
            (['users.id',
                'users.name',
                'users.email',
                'u.name as invited', 'links.link']);
        return $user;
    }

    public function gainFollowers() {
        $user = \DB::table('users')->where(['invited_by' => $this->id])
            ->get(['name']);
        return $user;
    }
}
