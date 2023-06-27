<?php
namespace App\Modules\Survey\Controllers;

use Form;
use App\Helpers\Logger;
use Illuminate\Http\Request;
use App\Modules\Log\Models\Log;
use App\Modules\Survey\Models\Survey;
use App\Modules\Desa\Models\Desa;
use App\Modules\JenisLahan\Models\JenisLahan;

use App\Http\Controllers\Controller;
use App\Modules\BatasAdministrasi\Models\BatasAdministrasi;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
	use Logger;
	protected $log;
	protected $title = "Survey";
	
	public function __construct(Log $log)
	{
		$this->log = $log;
	}

	public function index(Request $request)
	{
		$query = Survey::query();
		if($request->has('search')){
			$search = $request->get('search');
			// $query->where('name', 'like', "%$search%");
		}
		$data['data'] = $query->paginate(10)->withQueryString();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Survey::survey', array_merge($data, ['title' => $this->title]));
	}

	public function index_surveyor(Request $request)
	{
		$data['jenis_lahan'] = JenisLahan::get();
		$data['survey'] = Survey::get();
		$data['batas_adm'] = BatasAdministrasi::get();

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Survey::survey_surveyor', array_merge($data, ['title' => $this->title]));
	}

	public function destroy_surveyor(Request $request, $id)
	{
		$survey = Survey::find($id);
		$survey->deleted_by = Auth::id();
		$survey->save();
		$survey->delete();

		$text = 'menghapus '.$this->title;//.' '.$survey->what;
		$this->log($request, $text, ['survey.id' => $survey->id]);
		return back()->with('message_success', 'Survey berhasil dihapus!');
	}

	public function create(Request $request)
	{
		$ref_desa = Desa::all()->pluck('id_kecamatan','id');
		$ref_jenis_lahan = JenisLahan::all()->pluck('jenis_lahan','id');
		
		$data['forms'] = array(
			'id_desa' => ['Desa', Form::select("id_desa", $ref_desa, null, ["class" => "form-control select2"]) ],
			'id_jenis_lahan' => ['Jenis Lahan', Form::select("id_jenis_lahan", $ref_jenis_lahan, null, ["class" => "form-control select2"]) ],
			'nama' => ['Nama', Form::text("nama", old("nama"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'luas' => ['Luas', Form::text("luas", old("luas"), ["class" => "form-control","placeholder" => "", "required" => "required"]) ],
			'koordinat' => ['Koordinat', Form::textarea("koordinat", old("koordinat"), ["class" => "form-control rich-editor"]) ],
			'keterangan' => ['Keterangan', Form::text("keterangan", old("keterangan"), ["class" => "form-control","placeholder" => ""]) ],
			
		);

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Survey::survey_create', array_merge($data, ['title' => $this->title]));
	}

	public function create_surveyor(Request $request)
	{
		$data['ref_desa'] = Desa::all()->pluck('desa','id');
		$data['ref_jenis_lahan'] = JenisLahan::all()->pluck('jenis_lahan','id');

		$data['ref_desa']->prepend('-PILIH SALAH SATU-', '');
		$data['ref_jenis_lahan']->prepend('-PILIH SALAH SATU-', '');

		$this->log($request, 'membuka form tambah '.$this->title);
		return view('Survey::survey_surveyor_create', array_merge($data, ['title' => $this->title]));
	}

	public function store_surveyor(Request $request)
	{
		// $this->validate($request, [
		// 	'id_desa' => 'required',
		// 	'id_jenis_lahan' => 'required',
		// 	'nama' => 'required',
		// 	// 'luas' => 'required',
		// 	'koordinat' => 'required',
		// 	// 'keterangan' => 'required',
			
		// ]);

		$survey = new Survey();
		$survey->id_desa = $request->input("id_desa");
		$survey->id_jenis_lahan = $request->input("id_jenis_lahan");
		$survey->nama = $request->input("nama");
		$survey->luas = $request->input("luas");
		$survey->koordinat = $request->input("koordinat");
		$survey->keterangan = $request->input("keterangan");
		
		$survey->created_by = Auth::id();
		$survey->save();

		$id_survey = $survey->id;;

		Survey::update_properties($id_survey);

		$text = 'membuat '.$this->title; //' baru '.$survey->what;
		$this->log($request, $text, ['survey.id' => $survey->id]);
		return redirect()->route('dashboard')->with('message_success', 'Survey berhasil ditambahkan!');
	}

	public function show_surveyor(Request $request, $id)
	{
		$data['data'] = Survey::find($id);

		$this->log($request, 'melihat halaman manajemen data '.$this->title);
		return view('Survey::survey_surveyor_show', array_merge($data, ['title' => $this->title]));
	}

	function store(Request $request)
	{
		$this->validate($request, [
			'id_desa' => 'required',
			'id_jenis_lahan' => 'required',
			'nama' => 'required',
			'luas' => 'required',
			'koordinat' => 'required',
			'keterangan' => 'required',
			
		]);

		$survey = new Survey();
		$survey->id_desa = $request->input("id_desa");
		$survey->id_jenis_lahan = $request->input("id_jenis_lahan");
		$survey->nama = $request->input("nama");
		$survey->luas = $request->input("luas");
		$survey->koordinat = $request->input("koordinat");
		$survey->keterangan = $request->input("keterangan");
		
		$survey->created_by = Auth::id();
		$survey->save();

		$text = 'membuat '.$this->title; //' baru '.$survey->what;
		$this->log($request, $text, ['survey.id' => $survey->id]);
		return redirect()->route('survey.index')->with('message_success', 'Survey berhasil ditambahkan!');
	}

	public function show(Request $request, Survey $survey)
	{
		$data['survey'] = $survey;

		$text = 'melihat detail '.$this->title;//.' '.$survey->what;
		$this->log($request, $text, ['survey.id' => $survey->id]);
		return view('Survey::survey_detail', array_merge($data, ['title' => $this->title]));
	}

	public function edit(Request $request, Survey $survey)
	{
		$data['survey'] = $survey;

		$ref_desa = Desa::all()->pluck('id_kecamatan','id');
		$ref_jenis_lahan = JenisLahan::all()->pluck('jenis_lahan','id');
		
		$data['forms'] = array(
			'id_desa' => ['Desa', Form::select("id_desa", $ref_desa, null, ["class" => "form-control select2"]) ],
			'id_jenis_lahan' => ['Jenis Lahan', Form::select("id_jenis_lahan", $ref_jenis_lahan, null, ["class" => "form-control select2"]) ],
			'nama' => ['Nama', Form::text("nama", $survey->nama, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "nama"]) ],
			'luas' => ['Luas', Form::text("luas", $survey->luas, ["class" => "form-control","placeholder" => "", "required" => "required", "id" => "luas"]) ],
			'koordinat' => ['Koordinat', Form::textarea("koordinat", $survey->koordinat, ["class" => "form-control rich-editor"]) ],
			'keterangan' => ['Keterangan', Form::text("keterangan", $survey->keterangan, ["class" => "form-control","placeholder" => "", "id" => "keterangan"]) ],
			
		);

		$text = 'membuka form edit '.$this->title;//.' '.$survey->what;
		$this->log($request, $text, ['survey.id' => $survey->id]);
		return view('Survey::survey_update', array_merge($data, ['title' => $this->title]));
	}

	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'id_desa' => 'required',
			'id_jenis_lahan' => 'required',
			'nama' => 'required',
			'luas' => 'required',
			'koordinat' => 'required',
			'keterangan' => 'required',
			
		]);
		
		$survey = Survey::find($id);
		$survey->id_desa = $request->input("id_desa");
		$survey->id_jenis_lahan = $request->input("id_jenis_lahan");
		$survey->nama = $request->input("nama");
		$survey->luas = $request->input("luas");
		$survey->koordinat = $request->input("koordinat");
		$survey->keterangan = $request->input("keterangan");
		
		$survey->updated_by = Auth::id();
		$survey->save();


		$text = 'mengedit '.$this->title;//.' '.$survey->what;
		$this->log($request, $text, ['survey.id' => $survey->id]);
		return redirect()->route('survey.index')->with('message_success', 'Survey berhasil diubah!');
	}

	public function destroy(Request $request, $id)
	{
		$survey = Survey::find($id);
		$survey->deleted_by = Auth::id();
		$survey->save();
		$survey->delete();

		$text = 'menghapus '.$this->title;//.' '.$survey->what;
		$this->log($request, $text, ['survey.id' => $survey->id]);
		return back()->with('message_success', 'Survey berhasil dihapus!');
	}

}
