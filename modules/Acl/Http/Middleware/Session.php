<?php namespace Modules\Acl\Http\Middleware; 

use Closure;
use Illuminate\Contracts\Routing\TerminableMiddleware;
use Modules\Acl\Entities\User;

class Session implements TerminableMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	return $next($request);
    }
    
    public function terminate($request, $response)
    {
        $user_id = $request->user()->id;
        $authorizations = User::find($user_id)->authorizations()->get();
        
        foreach($authorizations as $authorization)
        {
            $perim=array();
            foreach($authorization->perimeters as $perimeter)
            {
                array_push($perim, $perimeter->id);
            }
            $auth[$authorization->module->slug][$authorization->role->slug] = $perim;
        }
        
        $request->session()->put('auth', $auth);
        
    }
}
