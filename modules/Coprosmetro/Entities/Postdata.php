<?php namespace Modules\Coprosmetro\Entities;
   
use Illuminate\Database\Eloquent\Model;

class Postdata extends Model {

    protected $table = 'avz_1_postdatas';

    protected $fillable = [];

    public function posts()
    {
        return $this->belongsTo('Modules\Coprosmetro\Entities\Post');
    }

}