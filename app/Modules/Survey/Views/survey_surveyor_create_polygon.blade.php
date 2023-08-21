<form action="{{ route('survey.surveyor.store') }}" method="POST">
    @csrf
    {!! Form::hidden('koordinat', null, ["id" => "koordinat"]) !!}
    <div class="row">
        <div class="col-md-3 form-group">
            <label for="">Nama</label>
        </div>
        <div class="col-md-9 form-group">
            <input type="text" name="nama" class="form-control" id="nama" placeholder="" required>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-3 form-group">
            <label for="">Lokasi</label>
        </div>
        <div class="col-md-9 form-group">
            {!! Form::select('id_desa', $ref_desa, NULL, ["class" => "form-control select2"]) !!}
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-3 form-group">
            <label for="">Jenis</label>
        </div>
        <div class="col-md-9 form-group">
            {!! Form::select('id_jenis_lahan', $ref_jenis_lahan, NULL, ["class" => "form-control select2"]) !!}
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-3 form-group">
            <label for="">Luas</label>
        </div>
        <div class="col-md-9 form-group">
            {!! Form::text('luas', NULL, ["class" => "form-control","id"=>"luas"]) !!}
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-3 form-group">
            <label for="">Keterangan</label>
        </div>
        <div class="col-md-9 form-group">
            {!! Form::textarea('keterangan', NULL, ["class" => "form-control", "rows" => "2"]) !!}
        </div>
    </div>
    
    <button class="btn btn-primary" type="submit">Simpan</button>
</form>
