<?php

namespace App\Http\Controllers\Auth;

use App\Link;
use App\User;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data) {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function registration($link = null) {
        $linkDb = env('APP_URL') . "/registration/" . $link;
        if (!User::first()) {
            return view('registration', ['link' => $link]);
        };
        return $link ? view('registration', ['link' => $linkDb]) : redirect('/');
    }

    public function registrationAction(Request $request) {
        $rules = [
            'name' => 'required|unique:users,name|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required',
            'repassword' => 'required',
        ];
        if ($u = User::first())
            $rules['link'] = 'required|exists:links,link';
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails() || $request->password != $request->repassword)
            return redirect('/');
        $linkDb = Link::where(['link' => $request->link, 'status_id' => 0])->first();
        if (!$linkDb) {
            $date = (new \DateTime())->sub(new \DateInterval('PT' . env('LINK_AVAILABLE') . 'S'));
            $linkDb = Link::where(['link' => $request->link])
                ->where('created_at', '>=', $date->format('Y-m-d H:i:s'))->first();
        }
        if ($u && $linkDb)
            $user = User::create(['name' => $request->name, 'email' => $request->email, 'password' => Hash::make
            ($request->password), 'invited_by' => $u->id]);
        if (!$u)
            $user = User::create(['name' => $request->name, 'email' => $request->email, 'password' => Hash::make
            ($request->password)]);
        return (isset($user) && $user) ? redirect('login') : redirect('/');
    }

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function login() {
        return view('login');
    }

    public function loginAction(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|exists:users,name|max:255',
            'password' => 'required',
        ]);
        if ($validator->fails())
            return redirect('/');
        $user = User::where('name', $request->name)->first();
        if (!$user || !Hash::check($request->password, $user->password))
            return redirect('/');
        $user->remember_token = str_random();
        $user->save();
        return redirect('users/' . $user->id)->withCookie('uid', $user->id)
            ->withCookie('token', $user->remember_token);
    }
}
