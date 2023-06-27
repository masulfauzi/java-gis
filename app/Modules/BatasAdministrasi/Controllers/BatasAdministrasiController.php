<?php
namespace App\Modules\BatasAdministrasi\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\BatasAdministrasi\Models\BatasAdministrasi;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BatasAdministrasiController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Batas Administrasi";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = BatasAdministrasi::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('BatasAdministrasi::batasadministrasi', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'nama' => ['Nama', Form::text("nama", old("nama"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'geojson' => ['Geojson', Form::text("geojson", old("geojson"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'keterangan' => ['Keterangan', Form::text("keterangan", old("keterangan"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('BatasAdministrasi::batasadministrasi_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'nama' => 'required',
			'geojson' => 'required',
			'keterangan' => 'required',
			
		]);

		$batasadministrasi = new BatasAdministrasi();
		$batasadministrasi->nama = $request->input("nama");
		$batasadministrasi->geojson = $request->input("geojson");
		$batasadministrasi->keterangan = $request->input("keterangan");
		
		$batasadministrasi->created_by = Auth::id();
		$batasadministrasi->save();

		$text = 'membuat '.$this->title; //' baru '.$batasadministrasi->what;
		$this->log($request, $text, ['batasadministrasi.id' => $batasadministrasi->id]);
		return redirect()->route('batasadministrasi.index')->with('message_success', 'Batas Administrasi berhasil ditambahkan!');
	}

	public function show(Request $request, BatasAdministrasi $batasadministrasi)
	{
		$data['batasadministrasi'] = $batasadministrasi;

		$text = 'melihat detail '.$this->title;//.' '.$batasadministrasi->what;
		$this->log($request, $text, ['batasadministrasi.id' => $batasadministrasi->id]);
		return view('BatasAdministrasi::batasadministrasi_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, BatasAdministrasi $batasadministrasi)
	{
		$data['batasadministrasi'] = $batasadministrasi;

		
		$data['forms'] = array(
			'nama' => ['Nama', Form::text("nama", $batasadministrasi->nama, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "nama"]) ],
			'geojson' => ['Geojson', Form::text("geojson", $batasadministrasi->geojson, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "geojson"]) ],
			'keterangan' => ['Keterangan', Form::text("keterangan", $batasadministrasi->keterangan, ["class" => "form-control","placeholder" => "", "id" => "keterangan"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$batasadministrasi->what;
		$this->log($request, $text, ['batasadministrasi.id' => $batasadministrasi->id]);
		return view('BatasAdministrasi::batasadministrasi_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'nama' => 'required',
			'geojson' => 'required',
			'keterangan' => 'required',
			
		]);
		
		$batasadministrasi = BatasAdministrasi::find($id);
		$batasadministrasi->nama = $request->input("nama");
		$batasadministrasi->geojson = $request->input("geojson");
		$batasadministrasi->keterangan = $request->input("keterangan");
		
		$batasadministrasi->updated_by = Auth::id();
		$batasadministrasi->save();


		$text = 'mengedit '.$this->title;//.' '.$batasadministrasi->what;
		$this->log($request, $text, ['batasadministrasi.id' => $batasadministrasi->id]);
		return redirect()->route('batasadministrasi.index')->with('message_success', 'Batas Administrasi berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$batasadministrasi = BatasAdministrasi::find($id);
		$batasadministrasi->deleted_by = Auth::id();
		$batasadministrasi->save();
		$batasadministrasi->delete();

		$text = 'menghapus '.$this->title;//.' '.$batasadministrasi->what;
		$this->log($request, $text, ['batasadministrasi.id' => $batasadministrasi->id]);
		return back()->with('message_success', 'Batas Administrasi berhasil dihapus!');
	}

}
