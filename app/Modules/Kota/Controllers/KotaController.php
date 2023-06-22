<?php
namespace App\Modules\Kota\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Kota\Models\Kota;
use App\Modules\Provinsi\Models\Provinsi;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KotaController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Kota";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Kota::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Kota::kota', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		$ref_provinsi = Provinsi::all()->pluck('provinsi','id');
		
		$data['forms'] = array(
			'id_provinsi' => ['Provinsi', Form::select("id_provinsi", $ref_provinsi, null, ["class" => "form-control select2"]) ],
			'kota' => ['Kota', Form::text("kota", old("kota"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'keterangan' => ['Keterangan', Form::text("keterangan", old("keterangan"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Kota::kota_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_provinsi' => 'required',
			'kota' => 'required',
			// 'keterangan' => 'required',
			
		]);

		$kota = new Kota();
		$kota->id_provinsi = $request->input("id_provinsi");
		$kota->kota = $request->input("kota");
		$kota->keterangan = $request->input("keterangan");
		
		$kota->created_by = Auth::id();
		$kota->save();

		$text = 'membuat '.$this->title; //' baru '.$kota->what;
		$this->log($request, $text, ['kota.id' => $kota->id]);
		return redirect()->route('kota.index')->with('message_success', 'Kota berhasil ditambahkan!');
	}

	public function show(Request $request, Kota $kota)
	{
		$data['kota'] = $kota;

		$text = 'melihat detail '.$this->title;//.' '.$kota->what;
		$this->log($request, $text, ['kota.id' => $kota->id]);
		return view('Kota::kota_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Kota $kota)
	{
		$data['kota'] = $kota;

		$ref_provinsi = Provinsi::all()->pluck('provinsi','id');
		
		$data['forms'] = array(
			'id_provinsi' => ['Provinsi', Form::select("id_provinsi", $ref_provinsi, null, ["class" => "form-control select2"]) ],
			'kota' => ['Kota', Form::text("kota", $kota->kota, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "kota"]) ],
			'keterangan' => ['Keterangan', Form::text("keterangan", $kota->keterangan, ["class" => "form-control","placeholder" => "", "id" => "keterangan"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$kota->what;
		$this->log($request, $text, ['kota.id' => $kota->id]);
		return view('Kota::kota_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_provinsi' => 'required',
			'kota' => 'required',
			'keterangan' => 'required',
			
		]);
		
		$kota = Kota::find($id);
		$kota->id_provinsi = $request->input("id_provinsi");
		$kota->kota = $request->input("kota");
		$kota->keterangan = $request->input("keterangan");
		
		$kota->updated_by = Auth::id();
		$kota->save();


		$text = 'mengedit '.$this->title;//.' '.$kota->what;
		$this->log($request, $text, ['kota.id' => $kota->id]);
		return redirect()->route('kota.index')->with('message_success', 'Kota berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$kota = Kota::find($id);
		$kota->deleted_by = Auth::id();
		$kota->save();
		$kota->delete();

		$text = 'menghapus '.$this->title;//.' '.$kota->what;
		$this->log($request, $text, ['kota.id' => $kota->id]);
		return back()->with('message_success', 'Kota berhasil dihapus!');
	}

}
