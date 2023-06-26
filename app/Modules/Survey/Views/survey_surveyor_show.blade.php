<table>
    <tr>
        <td>Nama</td>
        <td>:</td>
        <td class="form-control">{{ $data->nama }}</td>
    </tr>
    <tr>
        <td>Lokasi</td>
        <td>:</td>
        <td class="form-control">
            Desa {{ $data->desa['desa'] }} Kecamatan {{ $data->desa->kecamatan['kecamatan'] }} Kota {{ $data->desa->kecamatan->kota['kota'] }}
        </td>
    </tr>
    <tr>
        <td>Jenis Penggunaan Lahan</td>
        <td>:</td>
        <td class="form-control">{{ $data->jenisLahan['jenis_lahan'] }}</td>
    </tr>
</table>