<?php namespace Modules\Coprosmetro\Entities;
   
use Illuminate\Database\Eloquent\Model;

class Term extends Model {

    protected $table = 'avz_1_terms';

    protected $fillable = [];

    public function posts(){
        return $this->belongsToMany('Modules\Coprosmetro\Entities\Post');
    }
    public static function get_terms($taxonomy,$post_type){
        return Term::where('taxonomy',$taxonomy)->WhereHas('posts', function($q)use($post_type){
                        $q->where('posts.type', $post_type);
                    })->get();
    }
    public static function get_taxonomy($term){
        return Term::where('slug',$term)->first()->taxonomy;
    }
    public static function first_term_slug($query){
    	$termslug=$query->terms()->get()->toArray();
    	if (!is_null($termslug)){
			$termslug = array_pluck($termslug,'slug');	
			return $termslug[0];
		}
	}
    public static function retrieve_term_by_slug($term){
        return Term::where('slug',$term)->first();
    }

}