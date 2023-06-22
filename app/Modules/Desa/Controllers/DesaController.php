<?php
namespace App\Modules\Desa\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Desa\Models\Desa;
use App\Modules\Kecamatan\Models\Kecamatan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DesaController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Desa";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Desa::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Desa::desa', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		$ref_kecamatan = Kecamatan::all()->pluck('kecamatan','id');
		
		$data['forms'] = array(
			'id_kecamatan' => ['Kecamatan', Form::select("id_kecamatan", $ref_kecamatan, null, ["class" => "form-control select2"]) ],
			'desa' => ['Desa', Form::text("desa", old("desa"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'keterangan' => ['Keterangan', Form::text("keterangan", old("keterangan"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Desa::desa_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_kecamatan' => 'required',
			'desa' => 'required',
			// 'keterangan' => 'required',
			
		]);

		$desa = new Desa();
		$desa->id_kecamatan = $request->input("id_kecamatan");
		$desa->desa = $request->input("desa");
		$desa->keterangan = $request->input("keterangan");
		
		$desa->created_by = Auth::id();
		$desa->save();

		$text = 'membuat '.$this->title; //' baru '.$desa->what;
		$this->log($request, $text, ['desa.id' => $desa->id]);
		return redirect()->route('desa.index')->with('message_success', 'Desa berhasil ditambahkan!');
	}

	public function show(Request $request, Desa $desa)
	{
		$data['desa'] = $desa;

		$text = 'melihat detail '.$this->title;//.' '.$desa->what;
		$this->log($request, $text, ['desa.id' => $desa->id]);
		return view('Desa::desa_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Desa $desa)
	{
		$data['desa'] = $desa;

		$ref_kecamatan = Kecamatan::all()->pluck('id_kota','id');
		
		$data['forms'] = array(
			'id_kecamatan' => ['Kecamatan', Form::select("id_kecamatan", $ref_kecamatan, null, ["class" => "form-control select2"]) ],
			'desa' => ['Desa', Form::text("desa", $desa->desa, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "desa"]) ],
			'keterangan' => ['Keterangan', Form::text("keterangan", $desa->keterangan, ["class" => "form-control","placeholder" => "", "id" => "keterangan"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$desa->what;
		$this->log($request, $text, ['desa.id' => $desa->id]);
		return view('Desa::desa_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_kecamatan' => 'required',
			'desa' => 'required',
			'keterangan' => 'required',
			
		]);
		
		$desa = Desa::find($id);
		$desa->id_kecamatan = $request->input("id_kecamatan");
		$desa->desa = $request->input("desa");
		$desa->keterangan = $request->input("keterangan");
		
		$desa->updated_by = Auth::id();
		$desa->save();


		$text = 'mengedit '.$this->title;//.' '.$desa->what;
		$this->log($request, $text, ['desa.id' => $desa->id]);
		return redirect()->route('desa.index')->with('message_success', 'Desa berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$desa = Desa::find($id);
		$desa->deleted_by = Auth::id();
		$desa->save();
		$desa->delete();

		$text = 'menghapus '.$this->title;//.' '.$desa->what;
		$this->log($request, $text, ['desa.id' => $desa->id]);
		return back()->with('message_success', 'Desa berhasil dihapus!');
	}

}
