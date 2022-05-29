<?php

namespace App\Imports;

use App\Models\Shop;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpserts;

class ImportShop implements ToModel, WithUpserts
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function uniqueBy()
    {
        return 'email';
    }

    /**
     * @return string|array
     */

    public function model(array $row)
    {
        $email_exist = Shop::where([['email', '=', $row[4]]])->exists();

        if ($email_exist) {
            return;
        }

        return new Shop([
            'name'     => $row[1],
            'image'    => $row[2],
            'address' => $row[3],
            'email' => $row[4],
        ]);
    }
}
