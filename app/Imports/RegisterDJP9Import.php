<?php

namespace App\Imports;

use Auth;
use App\Models\TblRegister;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;

class RegisterDJP9Import implements ToModel, WithValidation, SkipsOnError, WithStartRow, SkipsOnFailure
{
    use Importable;

    /**
     * @param \Throwable $e
     */
    public function onError(\Throwable $e)
    {
        // Handle the exception how you'd like.
    }

    /**
     * @param Failure[] $failures
     */
    public function onFailure(Failure ...$failures)
    {
        // Handle the failures how you'd like.
    }

    public function model(array $row)
    {
        return new TblRegister([
            'no_surat'          => $row[1],
            'file_tp'           => 'FILE_TP_2',
            'jenis_register'    => $row[3],
            'wajib_pajak'       => $row[2],
            'note'              => $row[5],
            'petugas_penerima'  => $row[6],
            'datetime_input'    => formatDateTime($row[4]),
            'tbl_company_id'    => Auth::user()->tbl_company_id,
            'created_at'        => date('Y-m-d H:i:s'),
            'created_by'        => Auth::user()->user_id
        ]);
    }

    public function rules(): array
    {
        return [
            1 => Rule::unique('tbl_register', 'no_surat'), // Table name, field in your db
        ];
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }
}
