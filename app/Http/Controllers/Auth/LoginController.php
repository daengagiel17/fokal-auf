<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Socialite;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function redirectToProvider(Request $request, $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(Request $request, $provider)
    {
        try
        {
            $socialUser = Socialite::driver($provider)->user();
        }
        catch (\Exception $e) 
        { 
            return redirect()->route('home')->with('error', 'Sorry something wrong in server');
        }
        
        $user = User::where(['email' => $socialUser->getEmail()])->first();

        if(!$user)
        {
            $user  = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'foto' => $socialUser->getAvatar(),
                'password' => bcrypt('fokal123'),
            ]);
        }
        else
        {
            User::where('id', $user->id)->update([
                'foto' => $socialUser->getAvatar(),
            ]);            
        }

        $user = User::where(['email' => $socialUser->getEmail()])->first();
        auth()->login($user);
        
        return redirect()->route('home');
    }  
}
