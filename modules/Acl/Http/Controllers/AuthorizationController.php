<?php namespace Modules\Acl\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Modules\Acl\Entities\Authorization, Modules\Acl\Entities\Module, Modules\Acl\Entities\Role, Modules\Acl\Entities\Perimeter, Modules\Acl\Entities\User;
use Modules\Acl\Repositories\AuthorizationRepository;
use Illuminate\Http\Request;
use Modules\Acl\Http\Requests\AuthorizationCreateRequest;
use Modules\Acl\Http\Requests\AuthorizationUpdateRequest;

use App\Http\Requests;

class AuthorizationController extends Controller
{
    public function __construct(
        AuthorizationRepository $authorizations)
    {
        $this->authorizations = $authorizations;
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $counts = $this->authorizations->count();
        $authorizations= $this->authorizations->index();
        return view('acl::admin.authorizations.index', compact('authorizations','counts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $modules = Module::lists('name', 'id');
        $roles = Role::lists('name', 'id');
        $communes = Perimeter::lists('nom_com', 'id');
        $epcis = Perimeter::lists('nom_epci', 'epci');
        $users = User::lists('username', 'id');

        return view('acl::admin.authorizations.create', compact('modules','roles','communes','epcis','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(AuthorizationCreateRequest $request)
    {
        $this->authorizations->store($request->all());
        return redirect('admin/authorization')->with('success', trans('back/authorizations.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $authorization= $this->authorizations->find($id);
        return view('acl::admin.authorizations.show', compact('authorization'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $authorization= $this->authorizations->find($id);
        $modules = Module::lists('name', 'id');
        $roles = Role::lists('name', 'id');
        $communes = Perimeter::lists('nom_com', 'id');
        $epcis = Perimeter::lists('nom_epci', 'epci');
        $users = User::lists('username', 'id');

        return view('acl::admin.authorizations.edit', compact('authorization','modules','roles','communes','epcis','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(AuthorizationUpdateRequest $request, $id)
    {
        $this->authorizations->update($request->all(), $id);
        return redirect('admin/authorization')->with('success', trans('back/authorizations.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->authorizations->destroy($id);
        return redirect('admin/authorization')->with('ok', trans('back/authorizations.destroyed'));
    }
}
