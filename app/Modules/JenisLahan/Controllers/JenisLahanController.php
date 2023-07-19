<?php
namespace App\Modules\JenisLahan\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\JenisLahan\Models\JenisLahan;
use App\Modules\Geometry\Models\Geometry;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JenisLahanController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Jenis Lahan";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = JenisLahan::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('JenisLahan::jenislahan', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		$ref_geometry = Geometry::all()->pluck('geometry','id');
		$ref_geometry->prepend('-PILIH SALAH SATU-', '');
		
		$data['forms'] = array(
			'id_geometry' => ['Geometry', Form::select("id_geometry", $ref_geometry, null, ["class" => "form-control select2"]) ],
			'jenis_lahan' => ['Jenis Lahan', Form::text("jenis_lahan", old("jenis_lahan"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'warna' => ['Warna', Form::text("warna", old("warna"), ["class" => "form-control colorpicker","placeholder" => "", "required" => "required"]) ],
			'opacity' => ['Opacity', Form::range("opacity", old("opacity"), ["class" => "form-range","min" => "0", "max" => "100", "placeholder" => "", "required" => "required"]) ],
			'keterangan' => ['Keterangan', Form::text("keterangan", old("keterangan"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('JenisLahan::jenislahan_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_geometry' => 'required',
			'jenis_lahan' => 'required',
			'warna' => 'required',
			'opacity' => 'required',
			'keterangan' => 'required',
			
		]);

		$jenislahan = new JenisLahan();
		$jenislahan->id_geometry = $request->input("id_geometry");
		$jenislahan->jenis_lahan = $request->input("jenis_lahan");
		$jenislahan->warna = $request->input("warna");
		$jenislahan->opacity = $request->input("opacity")/100;
		$jenislahan->keterangan = $request->input("keterangan");
		
		$jenislahan->created_by = Auth::id();
		$jenislahan->save();

		$text = 'membuat '.$this->title; //' baru '.$jenislahan->what;
		$this->log($request, $text, ['jenislahan.id' => $jenislahan->id]);
		return redirect()->route('jenislahan.index')->with('message_success', 'Jenis Lahan berhasil ditambahkan!');
	}

	public function show(Request $request, JenisLahan $jenislahan)
	{
		$data['jenislahan'] = $jenislahan;

		$text = 'melihat detail '.$this->title;//.' '.$jenislahan->what;
		$this->log($request, $text, ['jenislahan.id' => $jenislahan->id]);
		return view('JenisLahan::jenislahan_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, JenisLahan $jenislahan)
	{
		$data['jenislahan'] = $jenislahan;

		$ref_geometry = Geometry::all()->pluck('geometry','id');
		$ref_geometry->prepend('-PILIH SALAH SATU-', '');
		
		$data['forms'] = array(
			'id_geometry' => ['Geometry', Form::select("id_geometry", $ref_geometry, $jenislahan->id_geometry, ["class" => "form-control select2"]) ],
			'jenis_lahan' => ['Jenis Lahan', Form::text("jenis_lahan", $jenislahan->jenis_lahan, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "jenis_lahan"]) ],
			'warna' => ['Warna', Form::text("warna", $jenislahan->warna, ["class" => "form-control colorpicker","placeholder" => "", "required" => "required", "id" => "warna"]) ],
			'opacity' => ['Opacity', Form::range("opacity", $jenislahan->opacity*100, ["class" => "form-range","min" => "0", "max" => "100","placeholder" => "", "required" => "required", "id" => "opacity"]) ],
			'keterangan' => ['Keterangan', Form::text("keterangan", $jenislahan->keterangan, ["class" => "form-control","placeholder" => "", "id" => "keterangan"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$jenislahan->what;
		$this->log($request, $text, ['jenislahan.id' => $jenislahan->id]);
		return view('JenisLahan::jenislahan_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_geometry' => 'required',
			'jenis_lahan' => 'required',
			'warna' => 'required',
			'opacity' => 'required',
			'keterangan' => 'required',
			
		]);
		
		$jenislahan = JenisLahan::find($id);
		$jenislahan->id_geometry = $request->input("id_geometry");
		$jenislahan->jenis_lahan = $request->input("jenis_lahan");
		$jenislahan->warna = $request->input("warna");
		$jenislahan->opacity = $request->input("opacity")/100;
		$jenislahan->keterangan = $request->input("keterangan");
		
		$jenislahan->updated_by = Auth::id();
		$jenislahan->save();


		$text = 'mengedit '.$this->title;//.' '.$jenislahan->what;
		$this->log($request, $text, ['jenislahan.id' => $jenislahan->id]);
		return redirect()->route('jenislahan.index')->with('message_success', 'Jenis Lahan berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$jenislahan = JenisLahan::find($id);
		$jenislahan->deleted_by = Auth::id();
		$jenislahan->save();
		$jenislahan->delete();

		$text = 'menghapus '.$this->title;//.' '.$jenislahan->what;
		$this->log($request, $text, ['jenislahan.id' => $jenislahan->id]);
		return back()->with('message_success', 'Jenis Lahan berhasil dihapus!');
	}

}
