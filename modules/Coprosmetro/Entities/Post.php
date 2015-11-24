<?php namespace Modules\Coprosmetro\Entities;
   
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model {

    protected $table = 'avz_1_posts';

    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
    protected $fillable = ['title', 'content','slug','status'];

    public function perimeter()
    {
        return $this->belongsTo('Modules\Acl\Entities\Perimeter','perimeter_id','id');
    }

    public function terms()
    {
        return $this->belongsToMany('Modules\Coprosmetro\Entities\Term');
    }

    public function postmetas()
    {
        return $this->hasMany('Modules\Coprosmetro\Entities\Postmeta');
    }

    public function postdatas()
    {
        return $this->hasMany('Modules\Coprosmetro\Entities\Postdata');
    }

}