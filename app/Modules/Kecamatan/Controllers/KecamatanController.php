<?php
namespace App\Modules\Kecamatan\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Kecamatan\Models\Kecamatan;
use App\Modules\Kota\Models\Kota;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KecamatanController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Kecamatan";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Kecamatan::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Kecamatan::kecamatan', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		$ref_kota = Kota::all()->pluck('kota','id');
		
		$data['forms'] = array(
			'id_kota' => ['Kota', Form::select("id_kota", $ref_kota, null, ["class" => "form-control select2"]) ],
			'kecamatan' => ['Kecamatan', Form::text("kecamatan", old("kecamatan"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'keterangan' => ['Keterangan', Form::text("keterangan", old("keterangan"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Kecamatan::kecamatan_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_kota' => 'required',
			'kecamatan' => 'required',
			// 'keterangan' => 'required',
			
		]);

		$kecamatan = new Kecamatan();
		$kecamatan->id_kota = $request->input("id_kota");
		$kecamatan->kecamatan = $request->input("kecamatan");
		$kecamatan->keterangan = $request->input("keterangan");
		
		$kecamatan->created_by = Auth::id();
		$kecamatan->save();

		$text = 'membuat '.$this->title; //' baru '.$kecamatan->what;
		$this->log($request, $text, ['kecamatan.id' => $kecamatan->id]);
		return redirect()->route('kecamatan.index')->with('message_success', 'Kecamatan berhasil ditambahkan!');
	}

	public function show(Request $request, Kecamatan $kecamatan)
	{
		$data['kecamatan'] = $kecamatan;

		$text = 'melihat detail '.$this->title;//.' '.$kecamatan->what;
		$this->log($request, $text, ['kecamatan.id' => $kecamatan->id]);
		return view('Kecamatan::kecamatan_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Kecamatan $kecamatan)
	{
		$data['kecamatan'] = $kecamatan;

		$ref_kota = Kota::all()->pluck('id_provinsi','id');
		
		$data['forms'] = array(
			'id_kota' => ['Kota', Form::select("id_kota", $ref_kota, null, ["class" => "form-control select2"]) ],
			'kecamatan' => ['Kecamatan', Form::text("kecamatan", $kecamatan->kecamatan, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "kecamatan"]) ],
			'keterangan' => ['Keterangan', Form::text("keterangan", $kecamatan->keterangan, ["class" => "form-control","placeholder" => "", "id" => "keterangan"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$kecamatan->what;
		$this->log($request, $text, ['kecamatan.id' => $kecamatan->id]);
		return view('Kecamatan::kecamatan_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_kota' => 'required',
			'kecamatan' => 'required',
			'keterangan' => 'required',
			
		]);
		
		$kecamatan = Kecamatan::find($id);
		$kecamatan->id_kota = $request->input("id_kota");
		$kecamatan->kecamatan = $request->input("kecamatan");
		$kecamatan->keterangan = $request->input("keterangan");
		
		$kecamatan->updated_by = Auth::id();
		$kecamatan->save();


		$text = 'mengedit '.$this->title;//.' '.$kecamatan->what;
		$this->log($request, $text, ['kecamatan.id' => $kecamatan->id]);
		return redirect()->route('kecamatan.index')->with('message_success', 'Kecamatan berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$kecamatan = Kecamatan::find($id);
		$kecamatan->deleted_by = Auth::id();
		$kecamatan->save();
		$kecamatan->delete();

		$text = 'menghapus '.$this->title;//.' '.$kecamatan->what;
		$this->log($request, $text, ['kecamatan.id' => $kecamatan->id]);
		return back()->with('message_success', 'Kecamatan berhasil dihapus!');
	}

}
