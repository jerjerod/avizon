<?php namespace Modules\Acl\Http\Controllers\Auth;

use Pingpong\Modules\Routing\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */
    protected $redirectTo = '/';
    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getEmail()
    {

        return view('acl::auth.password');
    }

    public function getReset()
    {

        return view('acl::auth.reset');
    }
}
