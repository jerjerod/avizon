<?php namespace Modules\Acl\Entities;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'modules';

    protected $fillable = ['slug','name'];
    
    public function authorizations()
    {
      return $this->hasMany('Modules\Acl\Entities\Authorization');
    }
}
