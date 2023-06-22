<?php

namespace App\Modules\Kecamatan\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Kota\Models\Kota;


class Kecamatan extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'kecamatan';
	protected $fillable   = ['*'];	

	public function kota(){
		return $this->belongsTo(Kota::class,"id_kota","id");
	}

}
