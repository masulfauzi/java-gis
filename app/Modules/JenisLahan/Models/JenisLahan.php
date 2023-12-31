<?php

namespace App\Modules\JenisLahan\Models;

use App\Helpers\UsesUuid;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Geometry\Models\Geometry;


class JenisLahan extends Model
{
	use SoftDeletes;
	use UsesUuid;

	protected $dates      = ['deleted_at'];
	protected $table      = 'jenis_lahan';
	protected $fillable   = ['*'];	

	public function geometry(){
		return $this->belongsTo(Geometry::class,"id_geometry","id");
	}

}
