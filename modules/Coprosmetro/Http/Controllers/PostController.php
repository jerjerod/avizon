<?php namespace Modules\Coprosmetro\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Modules\Coprosmetro\Repositories\PostRepository;
use Illuminate\Http\Request;
use App\Http\Requests;

class PostController extends Controller {
	
	protected $posts;

    public function __construct(PostRepository $posts)
    {
        $this->posts = $posts;
    }
    public function index()
    {     
        $perimeters = $this->posts->searchperim();
        return view($this->posts->modulename().'::map', compact('perimeters'));
    }

    public function indexAjax()
    {
        $geoms= $this->posts->geom();

        return response($geoms);
    }

    public function singleAjax(Request $request)
    {
        $geom = $this->posts->singlegeom($request->id);

        return response($geom);
    }

    public function popupAjax(Request $request)
    {
        $popup= $this->posts->popup($request->id);

        return response()->json($popup);
    }

    public function show($id)
    {
        $post = $this->posts->find($id);
        $other= $this->posts->popup($id);
        $perimeters = $this->posts->searchperim();
        return view($this->posts->modulename().'::show', compact('post','other','perimeters'));
    }
    
    public function search()
    {     
        $perimeters = $this->posts->searchperim();
        return view($this->posts->modulename().'::map', compact('perimeters'));
    }

    public function searchAjax()
    {
        $geoms = $this->posts->customsearch();

        return response($geoms);
    }
}