<?php

namespace App\Modules\Survey\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Desa\Models\Desa;
use App\Modules\JenisLahan\Models\JenisLahan;


class Survey extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'survey';
	protected $fillable   = ['*'];	

	public function desa(){
		return $this->belongsTo(Desa::class,"id_desa","id");
	}
public function jenisLahan(){
		return $this->belongsTo(JenisLahan::class,"id_jenis_lahan","id");
	}

}
