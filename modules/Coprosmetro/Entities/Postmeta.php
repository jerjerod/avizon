<?php namespace Modules\Coprosmetro\Entities;
   
use Illuminate\Database\Eloquent\Model;

class Postmeta extends Model {

    protected $table = 'avz_1_postmetas';

    protected $fillable = [];

    public function posts()
    {
        return $this->belongsTo('Modules\Coprosmetro\Entities\Post');
    }

}