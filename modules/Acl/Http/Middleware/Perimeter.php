<?php namespace Modules\Acl\Http\Middleware;

use Closure;
use Modules\Acl\Entities\Module;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class Perimeter
{
    public function handle($request, Closure $next)
    {
        $module = Module::where('slug', '=',$request->segment(1))->firstOrFail();

        if (!is_null(session()->get('auth.'.$module->slug.'.visitor')) && !is_null(session()->get('auth.'.$module->slug.'.contributor'))) 
        {
            $perim = array_merge(session()->get('auth.'.$module->slug.'.visitor'),session()->get('auth.'.$module->slug.'.contributor'));
        }
        else if (is_null(session()->get('auth.'.$module->slug.'.visitor')) && !is_null(session()->get('auth.'.$module->slug.'.contributor')))
        {
            $perim = session()->get('auth.'.$module->slug.'.contributor');
        }
        else if (!is_null(session()->get('auth.'.$module->slug.'.visitor')) && is_null(session()->get('auth.'.$module->slug.'.contributor')))
        {
            $perim = session()->get('auth.'.$module->slug.'.visitor');
        }

        $perim_id = DB::table('avz_'.$module->id.'_posts')->find($request->id)->perimeter_id;
        
        if (in_array($perim_id, $perim)) {
            return $next($request);
        } else {
            return new RedirectResponse(url('/'.$module->slug.''));
        }
    }
}