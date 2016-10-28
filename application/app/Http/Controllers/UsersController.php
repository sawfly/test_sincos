<?php

namespace App\Http\Controllers;

use App\Link;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return response(['status' => 'Forbidden'], 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $user = (new User())->withInvitedBy($id);
        $user[0]->followers = $user[0]->gainFollowers();
        return view('user', ['name' => $user[0]->name, 'invited_by' => $user[0]->invited, 'link' => $user[0]->link,
            'id' => $user[0]->id, 'email' => $user[0]->email, 'followers' => $user[0]->followers]);
    }

    public function addLinkAction($id) {
        $validator = \Validator::make(['id' => $id], [
            'id' => 'required|exists:users,id|max:255'
        ]);
        if ($validator->fails())
            return redirect('/');
        $link = Link::where(['user_id' => $id, 'status_id' => '0'])->first();
        if ($link) {
            $link->status_id = 1;
            $link->save();
        }
        $l = env('APP_URL') . "/registration/" . str_random('69');

        return Link::create(['link'=>$l, 'user_id'=>$id]) ? redirect("/users/$id") : redirect('/');
    }
}
