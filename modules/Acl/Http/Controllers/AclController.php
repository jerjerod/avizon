<?php namespace Modules\Acl\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Modules\Acl\Repositories\ModuleRepository;
use Modules\Acl\Repositories\UserRepository;
use Modules\Acl\Repositories\RoleRepository;
use Modules\Acl\Repositories\PerimeterRepository;
use Illuminate\Http\Request;
use App\Http\Requests;

class AclController extends Controller {
	
	public function index(
        ModuleRepository $modules, 
        RoleRepository $roles,
        PerimeterRepository $perimeters,
        UserRepository $users)
    {
    $nb_modules = $modules->count();
    $nb_roles = $roles->count();
    $nb_perimeters = $perimeters->count();
    $nb_users = $users->count();
 
    return view('acl::admin.dashboard', compact('nb_modules', 'nb_roles', 'nb_perimeters', 'nb_users'));
    }
	
}