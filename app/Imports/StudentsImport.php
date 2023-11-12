<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Row;

class StudentsImport implements OnEachRow, WithUpserts,WithHeadingRow
{
    // /**
    // * @param array $row
    // *
    // * @return \Illuminate\Database\Eloquent\Model|null
    // */
    // public function model(array $row)
    // {
    //     Log::info('Row data:', $row);
    //     $data = $row;
    //     return new Student([
    //         'name'     => $row['name'],
    //         'email'    => $row['email'],
    //         'address'    => $row['address'],
    //         'course'    => $row['course'],
    //      ]);
    // }

    public function onRow(Row $row)
    {
        $row = $row->toArray();

        Student::updateOrInsert(
            [
                'email'    => $row['email'],
            ],
            [
                'name'     => $row['name'],
                'email'    => $row['email'],
                'address'    => $row['address'],
                'course'    => $row['course'],
            ]
        );
    }

    public function uniqueBy()
    {
        return 'email';
    }
}
