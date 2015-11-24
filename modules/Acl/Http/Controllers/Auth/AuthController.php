<?php namespace Modules\Acl\Http\Controllers\Auth;

use Pingpong\Modules\Routing\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Modules\Acl\Entities\User;

class AuthController extends Controller
{
    
    protected $redirectPath = '/';
    protected $loginPath = '/login';
    protected $redirectAfterLogout = '/login';

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
    use AuthenticatesUsers, ThrottlesLogins;
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    private function lockoutTime() 
    {
        return property_exists($this, 'lockoutTime') ? $this->lockoutTime : 180;
    }

    public function getLogin()
    {
        if (view()->exists('acl::auth.authenticate')) {
            return view('acl::auth.authenticate');
        }

        return view('acl::auth.login');
    }
    
}