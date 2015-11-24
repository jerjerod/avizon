<?php namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Model;

class Authorization extends Model
{
    protected $table = 'authorizations';
    protected $fillable = ['module_id','role_id'];

    
	public function module()
	{
	  return $this->belongsTo('Modules\Acl\Entities\Module');
	}
	public function role()
	{
	  return $this->belongsTo('Modules\Acl\Entities\Role');
	}
	public function users()
	{
	  return $this->belongsToMany('Modules\Acl\Entities\User');
	}
	public function perimeters()
	{
	  return $this->belongsToMany('Modules\Acl\Entities\Perimeter');
	}
}
