<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $seed_category = [
            [
                'name'          => 'Gaji',
                'description'   => 'Deskripsi Gaji',
                'type'          => 'Pemasukan',
            ],
            [
                'name'          => 'Tunjangan',
                'description'   => 'Deskripsi Tunjangan',
                'type'          => 'Pemasukan',
            ],
            [
                'name'          => 'Bonus',
                'description'   => 'Deskripsi Bonus',
                'type'          => 'Pemasukan',
            ],
            [
                'name'          => 'Sewa Kost',
                'description'   => 'Deskripsi Sewa Kost',
                'type'          => 'Pengeluaran',
            ],
            [
                'name'          => 'Makanan',
                'description'   => 'Deskripsi Makanan',
                'type'          => 'Pengeluaran',
            ],
            [
                'name'          => 'Pakaian',
                'description'   => 'Deskripsi Pakaian',
                'type'          => 'Pengeluaran',
            ],
            [
                'name'          => 'Nonton Bioskop',
                'description'   => 'Deskripsi Nonton Bioskop',
                'type'          => 'Pengeluaran',
            ],
        ];

        foreach ($seed_category as $value) {
            DB::table('categories')->insert([
                'name'          => $value['name'],
                'description'   => $value['description'],
                'type'          => $value['type'],
            ]);
        }

        
    }
}
