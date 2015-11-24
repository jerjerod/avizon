<?php namespace Modules\Acl\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Modules\Acl\Entities\Module;
use Modules\Acl\Repositories\ModuleRepository;
use Modules\Acl\Http\Requests\ModuleCreateRequest;
use Modules\Acl\Http\Requests\ModuleUpdateRequest;
use Illuminate\Http\Request;
use App\Http\Requests;

class ModuleController extends Controller
{
    protected $modules;

    public function __construct(
        ModuleRepository $modules)
    {
        $this->modules = $modules;
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $counts = $this->modules->count();
        $modules= $this->modules->index();
        return view('acl::admin.modules.index', compact('modules','counts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('acl::admin.modules.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(ModuleCreateRequest $request)
    {
        $this->modules->store($request->all());
        return redirect('admin/module')->with('success', trans('back/modules.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $module= $this->modules->find($id);
        return view('acl::admin.modules.show', compact('module'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $module= $this->modules->find($id);
        return view('acl::admin.modules.edit', compact('module'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(ModuleUpdateRequest $request, $id)
    {
        $this->modules->update($request->all(), $id);
        return redirect('admin/module')->with('success', trans('back/modules.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->modules->destroy($id);
        return redirect('admin/module')->with('ok', trans('back/modules.destroyed'));
    }
}
