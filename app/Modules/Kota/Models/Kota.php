<?php

namespace App\Modules\Kota\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Provinsi\Models\Provinsi;


class Kota extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'kota';
	protected $fillable   = ['*'];	

	public function provinsi(){
		return $this->belongsTo(Provinsi::class,"id_provinsi","id");
	}

}
