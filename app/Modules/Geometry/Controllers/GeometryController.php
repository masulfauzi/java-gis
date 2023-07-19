<?php
namespace App\Modules\Geometry\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Geometry\Models\Geometry;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GeometryController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Geometry";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Geometry::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Geometry::geometry', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'geometry' => ['Geometry', Form::text("geometry", old("geometry"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Geometry::geometry_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'geometry' => 'required',
			
		]);

		$geometry = new Geometry();
		$geometry->geometry = $request->input("geometry");
		
		$geometry->created_by = Auth::id();
		$geometry->save();

		$text = 'membuat '.$this->title; //' baru '.$geometry->what;
		$this->log($request, $text, ['geometry.id' => $geometry->id]);
		return redirect()->route('geometry.index')->with('message_success', 'Geometry berhasil ditambahkan!');
	}

	public function show(Request $request, Geometry $geometry)
	{
		$data['geometry'] = $geometry;

		$text = 'melihat detail '.$this->title;//.' '.$geometry->what;
		$this->log($request, $text, ['geometry.id' => $geometry->id]);
		return view('Geometry::geometry_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Geometry $geometry)
	{
		$data['geometry'] = $geometry;

		
		$data['forms'] = array(
			'geometry' => ['Geometry', Form::text("geometry", $geometry->geometry, ["class" => "form-control","placeholder" => "", "id" => "geometry"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$geometry->what;
		$this->log($request, $text, ['geometry.id' => $geometry->id]);
		return view('Geometry::geometry_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'geometry' => 'required',
			
		]);
		
		$geometry = Geometry::find($id);
		$geometry->geometry = $request->input("geometry");
		
		$geometry->updated_by = Auth::id();
		$geometry->save();


		$text = 'mengedit '.$this->title;//.' '.$geometry->what;
		$this->log($request, $text, ['geometry.id' => $geometry->id]);
		return redirect()->route('geometry.index')->with('message_success', 'Geometry berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$geometry = Geometry::find($id);
		$geometry->deleted_by = Auth::id();
		$geometry->save();
		$geometry->delete();

		$text = 'menghapus '.$this->title;//.' '.$geometry->what;
		$this->log($request, $text, ['geometry.id' => $geometry->id]);
		return back()->with('message_success', 'Geometry berhasil dihapus!');
	}

}
