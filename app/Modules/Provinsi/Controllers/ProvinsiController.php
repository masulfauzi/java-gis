<?php
namespace App\Modules\Provinsi\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Provinsi\Models\Provinsi;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProvinsiController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Provinsi";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Provinsi::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Provinsi::provinsi', array_merge($data, ['title' => $this->title]));
	}

	public function create(Request $request)
	{
		
		$data['forms'] = array(
			'provinsi' => ['Provinsi', Form::text("provinsi", old("provinsi"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'keterangan' => ['Keterangan', Form::text("keterangan", old("keterangan"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Provinsi::provinsi_create', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'provinsi' => 'required',
			// 'keterangan' => 'required',
			
		]);

		$provinsi = new Provinsi();
		$provinsi->provinsi = $request->input("provinsi");
		$provinsi->keterangan = $request->input("keterangan");
		
		$provinsi->created_by = Auth::id();
		$provinsi->save();

		$text = 'membuat '.$this->title; //' baru '.$provinsi->what;
		$this->log($request, $text, ['provinsi.id' => $provinsi->id]);
		return redirect()->route('provinsi.index')->with('message_success', 'Provinsi berhasil ditambahkan!');
	}

	public function show(Request $request, Provinsi $provinsi)
	{
		$data['provinsi'] = $provinsi;

		$text = 'melihat detail '.$this->title;//.' '.$provinsi->what;
		$this->log($request, $text, ['provinsi.id' => $provinsi->id]);
		return view('Provinsi::provinsi_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Provinsi $provinsi)
	{
		$data['provinsi'] = $provinsi;

		
		$data['forms'] = array(
			'provinsi' => ['Provinsi', Form::text("provinsi", $provinsi->provinsi, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "provinsi"]) ],
			'keterangan' => ['Keterangan', Form::text("keterangan", $provinsi->keterangan, ["class" => "form-control","placeholder" => "", "id" => "keterangan"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$provinsi->what;
		$this->log($request, $text, ['provinsi.id' => $provinsi->id]);
		return view('Provinsi::provinsi_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'provinsi' => 'required',
			'keterangan' => 'required',
			
		]);
		
		$provinsi = Provinsi::find($id);
		$provinsi->provinsi = $request->input("provinsi");
		$provinsi->keterangan = $request->input("keterangan");
		
		$provinsi->updated_by = Auth::id();
		$provinsi->save();


		$text = 'mengedit '.$this->title;//.' '.$provinsi->what;
		$this->log($request, $text, ['provinsi.id' => $provinsi->id]);
		return redirect()->route('provinsi.index')->with('message_success', 'Provinsi berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$provinsi = Provinsi::find($id);
		$provinsi->deleted_by = Auth::id();
		$provinsi->save();
		$provinsi->delete();

		$text = 'menghapus '.$this->title;//.' '.$provinsi->what;
		$this->log($request, $text, ['provinsi.id' => $provinsi->id]);
		return back()->with('message_success', 'Provinsi berhasil dihapus!');
	}

}
