<table>
    <thead>
    <tr>
        <th>Wajib Pajak</th>
        <th>No Surat</th>
        <th>Jenis Surat</th>
        <th>No Telepon</th>
    </tr>
    </thead>
    <tbody>
    @foreach($registers as $register)
        <tr>
            <td>{{ $register->wajib_pajak }}</td>
            <td>{{ $register->no_surat }}</td>
            <td>{{ $register->jenis_register }}</td>
            <td>{{ $register->phone }}</td>
        </tr>
    @endforeach
    </tbody>
</table>