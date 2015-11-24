<?php namespace Modules\Coprosmetro\Repositories;

use Modules\Coprosmetro\Entities\Post;
use Modules\Acl\Entities\Perimeter;
use Illuminate\Support\Facades\DB;
use Module;

class PostRepository extends BaseRepository
{
	public function __construct(Post $post)
	{
		$this->model = $post;
	}

     public function modulename()
    {
        $module = Module::get('coprosmetro')->getLowerName();
        return $module;
    }

	public function perim()
    {
        if (!is_null(session()->get('auth.'.$this->modulename().'.visitor')) && !is_null(session()->get('auth.'.$this->modulename().'.contributor'))) 
        {
            $perim = array_merge(session()->get('auth.'.$this->modulename().'.visitor'),session()->get('auth.'.$this->modulename().'.contributor'));
        }
        else if (is_null(session()->get('auth.'.$this->modulename().'.visitor')) && !is_null(session()->get('auth.'.$this->modulename().'.contributor')))
        {
            $perim = session()->get('auth.'.$this->modulename().'.contributor');
        }
        else if (!is_null(session()->get('auth.'.$this->modulename().'.visitor')) && is_null(session()->get('auth.'.$this->modulename().'.contributor')))
        {
            $perim = session()->get('auth.'.$this->modulename().'.visitor');
        }
        return $perim;
    }

	public function index()
	{
		return $this->model->all();
	}
	
	public function geom()
	{
		$posts = $this->model->whereIn('perimeter_id',$this->perim())->get(array('id',DB::raw('ST_AsGeoJSON(point,6) as geom')));
        $geoms ='{"type": "FeatureCollection", "features": [';
        foreach($posts as $key=>$post)
        {
            if(!empty($post->geom))
            {
                if($key>0)
                {
                    $geoms .= ',';
                }
               $geoms .= '{"type": "Feature", "geometry":'.$post->geom.', "properties": {"id":"'.$post->id.'"}}'; 
            }
        }
        $geoms .=']}';
        return $geoms;
	}

	public function singlegeom($id)
	{
		$post = $this->model->whereIn('perimeter_id',$this->perim())->where('id',$id)->first(array('id',DB::raw('ST_AsGeoJSON(polygon,6) as geom')));
		$geom = '{ "type": "FeatureCollection", "features": [ {"type": "Feature", "geometry": '. $post->geom. '}]}';
        return $geom;
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
	    $post = new $this->model;
	    $post->module_id = $inputs['module'];
	    $post->role_id = $inputs['role'];
	    $post->save();
	    $post->terms()->attach($inputs['term']);
	}

	public function update($inputs, $id)
	{		
		$post = $this->model->find($id);
		$post->fill($inputs);
		$post->save();
		$post->terms()->sync($inputs['term']);
	}
	public function destroy($id)
	{
		$post = $this->model->find($id);
		$post->delete();
	}

	public function popup($id)
	{
		$post = $this->model->find($id);
		$popup['post']['slug'] = $post->slug;
        $popup['terms']['commune'] = $post->perimeter->nom_com;
        
        foreach ($post->postmetas as $key => $meta) {
            $popup['meta'][$meta->metakey] = json_decode($meta->metavalue);
        }
        foreach ($post->postdatas as $key => $data) {
            $popup['data'][$data->datakey] = $data->datavalue;
        }

        return $popup;
	}
    public function searchperim()
    {
        $userperim = Perimeter::whereIn('id',$this->perim())->get();
        return $userperim;
    }

	public function customsearch()
	{
		$geoms = $this->model->whereIn('perimeter_id',$this->perim()); 
        //communes
        if (isset($_GET['com'])){
            $com = $_GET['com'];
            $geoms = $geoms->whereIn('perimeter_id',$com);
        }
        //nb de logements
        if (isset($_GET['taille'])){
            $taille = $_GET['taille'];
            if (!empty($taille['min']) || !empty($taille['max'])){
                $geoms = $geoms->whereHas('postmetas', function($q)use($taille){
                            if(!empty($taille['min']) && empty($taille['max'])){
                                $q->where('metakey', 'nb_log')->whereRaw('metavalue::int >='.$taille['min']);
                            }else if(empty($taille['min']) && !empty($taille['max'])){
                                $q->where('metakey', 'nb_log')->whereRaw('metavalue::int <='.$taille['max']);
                            }else{
                                $q->where('metakey', 'nb_log')->whereRaw('metavalue::int >='.$taille['min'].' AND metavalue::int <='.$taille['max']);
                            }
                        });
            }
        }
        //date de construction
        if (isset($_GET['date'])){
            $date = $_GET['date'];
            if (!empty($date['min']) || !empty($date['max'])){
                $geoms = $geoms->whereHas('postmetas', function($q)use($date){
                            if(!empty($date['min']) && empty($date['max'])){
                                $q->where('metakey', 'date_construction')->whereRaw('metavalue::int >='.$date['min']);
                            }else if(empty($date['min']) && !empty($date['max'])){
                                $q->where('metakey', 'date_construction')->whereRaw('metavalue::int <='.$date['max']);
                            }else{
                                $q->where('metakey', 'date_construction')->whereRaw('metavalue::int >='.$date['min'].' AND metavalue::int <='.$date['max']);
                            }
                        });
            }
        }
        // Prix du marché
        if (isset($_GET['prix'])){
            $prix = $_GET['prix'];
            if (!empty($prix['min']) || !empty($prix['max'])){
                $geoms = $geoms->whereHas('postmetas', function($q)use($prix){
                            if(!empty($prix['min']) && empty($prix['max'])){
                                $q->where('metakey', 'prix_marche')->whereRaw('metavalue::int >='.$prix['min']);
                            }else if(empty($prix['min']) && !empty($prix['max'])){
                                $q->where('metakey', 'prix_marche')->whereRaw('metavalue::int <='.$prix['max']);
                            }else{
                                $q->where('metakey', 'prix_marche')->whereRaw('metavalue::int >='.$prix['min'].' AND metavalue::int <='.$prix['max']);
                            }
                        });
            }
        }
        // interventions
        if (isset($_GET['atlas93'])){
            $geoms = $geoms->whereHas('postmetas', function($q){
                        $q->where('metakey', 'atlas93');
                    });
        }
        if (isset($_GET['atlas99'])){
            $geoms = $geoms->whereHas('postmetas', function($q){
                        $q->where('metakey', 'atlas99');
                    });
        }
        if (isset($_GET['opatb'])){
            $geoms = $geoms->whereHas('postmetas', function($q){
                        $q->where('metakey', 'opatb');
                    });
        }
        if (isset($_GET['opah'])){
            $geoms = $geoms->whereHas('postmetas', function($q){
                        $q->where('metakey', 'opah');
                    });
        }
        if (isset($_GET['etucad'])){
            $geoms = $geoms->whereHas('postmetas', function($q){
                        $q->where('metakey', 'etucad');
                    });
        }
        if (isset($_GET['etupreop'])){
            $geoms = $geoms->whereHas('postmetas', function($q){
                        $q->where('metakey', 'etupreop');
                    });
        }
        if (isset($_GET['suivi'])){
            $geoms = $geoms->whereHas('postmetas', function($q){
                        $q->where('metakey', 'suivi');
                    });
        }
        if (isset($_GET['murmur'])){
            $geoms = $geoms->whereHas('postmetas', function($q){
                        $q->where('metakey', 'murmur');
                    });
        }
        // Causes de fragilité
        if (isset($_GET['c1_frag'])){
            $geoms = $geoms->whereHas('postmetas', function($q){
                        $q->where('metakey', 'c1_frag');
                    });
        }
        if (isset($_GET['c2_frag'])){
            $geoms = $geoms->whereHas('postmetas', function($q){
                        $q->where('metakey', 'c2_frag');
                    });
        }
        if (isset($_GET['c3_frag'])){
            $geoms = $geoms->whereHas('postmetas', function($q){
                        $q->where('metakey', 'c3_frag');
                    });
        }
        if (isset($_GET['c4_frag'])){
            $geoms = $geoms->whereHas('postmetas', function($q){
                        $q->where('metakey', 'c4_frag');
                    });
        }
        if (isset($_GET['c5_frag'])){
            $geoms = $geoms->whereHas('postmetas', function($q){
                        $q->where('metakey', 'c5_frag');
                    });
        }
        if (isset($_GET['c6_frag'])){
            $geoms = $geoms->whereHas('postmetas', function($q){
                        $q->where('metakey', 'c6_frag');
                    });
        }
        if (isset($_GET['c7_frag'])){
            $geoms = $geoms->whereHas('postmetas', function($q){
                        $q->where('metakey', 'c7_frag');
                    });
        }
        //Signalement
        if (isset($_GET['signal1'])){
            $geoms = $geoms->whereHas('postmetas', function($q){
                        $q->where('metakey', 'signal1');
                    });
        }
        if (isset($_GET['signal2'])){
            $geoms = $geoms->whereHas('postmetas', function($q){
                        $q->where('metakey', 'signal2');
                    });
        }
        if (isset($_GET['signal3'])){
            $geoms = $geoms->whereHas('postmetas', function($q){
                        $q->where('metakey', 'signal3');
                    });
        }
        if (isset($_GET['signal4'])){
            $geoms = $geoms->whereHas('postmetas', function($q){
                        $q->where('metakey', 'signal4');
                    });
        }

        $geoms = $geoms->get(array('id',DB::raw('ST_AsGeoJSON(point,6) as geom')));

        $search ='{"type": "FeatureCollection", "features": [';
        foreach($geoms as $key=>$geom)
        {
            if(!empty($geom->geom))
            {
                if($key>0)
                {
                    $search .= ',';
                }
               $search .= '{"type": "Feature", "geometry":'.$geom->geom.', "properties": {"id":"'.$geom->id.'"}}'; 
            }
        }
        $search .=']}';
        return $search;
        
        
	}
}