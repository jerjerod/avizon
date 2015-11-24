<?php namespace Modules\Acl\Repositories;

use Modules\Acl\Entities\Authorization, Modules\Acl\Entities\Module;

class ModuleRepository extends BaseRepository
{
	public function __construct(Module $module)
	{
		$this->model = $module;
	}

	public function index()
	{

		return $this->model->with('authorizations')->get();
	}

	public function count()
	{
		return $this->model->count();
	}

	public function find($id)
	{
		return $this->model->findOrFail($id);
	}

	public function store($inputs)
	{
	    $module = new $this->model;
	    $module->slug = $inputs['slug'];
	    $module->name = $inputs['name'];
	    $module->save();
	}

	public function update($inputs, $id)
	{		
		$module = $this->model->find($id);
		$module->fill($inputs);
		$module->save();
	}
	public function destroy($id)
	{
		$module = $this->model->find($id);
		$module->delete();
	}
}