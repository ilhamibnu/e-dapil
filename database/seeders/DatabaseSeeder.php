<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Desa;
use App\Models\Kecamatan;
use Illuminate\Database\Seeder;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
        ]);

        Kecamatan::create([
            'name' => 'Banyuanyar',
        ]);

        Kecamatan::create([
            'name' => 'Leces',
        ]);

        Kecamatan::create([
            'name' => 'Tegalsiwalan',
        ]);



        Desa::create([
            'name' => 'Alassapi',
            'id_kecamatan' => 1,
        ]);

        Desa::create([
            'name' => 'Banyuanyar Kidul',
            'id_kecamatan' => 1,
        ]);
        Desa::create([
            'name' => 'Banyuanyar Tengah',
            'id_kecamatan' => 1,
        ]);

        Desa::create([
            'name' => 'Blado Wetan',
            'id_kecamatan' => 1,
        ]);

        Desa::create([
            'name' => 'Gading Kulon',
            'id_kecamatan' => 1,
        ]);

        Desa::create([
            'name' => 'Gununggeni',
            'id_kecamatan' => 1,
        ]);

        Desa::create([
            'name' => 'Banyuanyar Kidul',
            'id_kecamatan' => 1,
        ]);

        Desa::create([
            'name' => 'Klenang Kidul',
            'id_kecamatan' => 1,
        ]);

        Desa::create([
            'name' => 'Klenang Lor',
            'id_kecamatan' => 1,
        ]);

        Desa::create([
            'name' => 'Liprak Kidul',
            'id_kecamatan' => 1,
        ]);

        Desa::create([
            'name' => 'Liprak Kulon',
            'id_kecamatan' => 1,
        ]);

        Desa::create([
            'name' => 'Liprak Wetan',
            'id_kecamatan' => 1,
        ]);

        Desa::create([
            'name' => 'Pendil',
            'id_kecamatan' => 1,
        ]);

        Desa::create([
            'name' => 'Sentulan',
            'id_kecamatan' => 1,
        ]);

        Desa::create([
            'name' => 'Tarokan',
            'id_kecamatan' => 1,
        ]);


        Desa::create([
            'name' => 'Clarak',
            'id_kecamatan' => 2,
        ]);

        Desa::create([
            'name' => 'Jorongan',
            'id_kecamatan' => 2,
        ]);

        Desa::create([
            'name' => 'Kerpangan',
            'id_kecamatan' => 2,
        ]);

        Desa::create([
            'name' => 'Leces',
            'id_kecamatan' => 2,
        ]);

        Desa::create([
            'name' => 'Malasan Kulon',
            'id_kecamatan' => 2,
        ]);

        Desa::create([
            'name' => 'Pondok Wuluh',
            'id_kecamatan' => 2,
        ]);

        Desa::create([
            'name' => 'Sumberkedawung',
            'id_kecamatan' => 2,
        ]);

        Desa::create([
            'name' => 'Tigasan Kulon',
            'id_kecamatan' => 2,
        ]);

        Desa::create([
            'name' => 'Tigasan Wetan',
            'id_kecamatan' => 2,
        ]);

        Desa::create([
            'name' => 'Warujinggo',
            'id_kecamatan' => 2,
        ]);


        Desa::create([
            'name' => 'Banjarsawah',
            'id_kecamatan' => 3,
        ]);

        Desa::create([
            'name' => 'Bladokulon',
            'id_kecamatan' => 3,
        ]);

        Desa::create([
            'name' => 'Bulujaran Lor',
            'id_kecamatan' => 3,
        ]);

        Desa::create([
            'name' => 'Gunung Bekel',
            'id_kecamatan' => 3,
        ]);

        Desa::create([
            'name' => 'Malasan Wetan',
            'id_kecamatan' => 3,
        ]);

        Desa::create([
            'name' => 'Paras',
            'id_kecamatan' => 3,
        ]);

        Desa::create([
            'name' => 'Sumberbulu',
            'id_kecamatan' => 3,
        ]);

        Desa::create([
            'name' => 'Sumberkledung',
            'id_kecamatan' => 3,
        ]);

        Desa::create([
            'name' => 'Tegalmojo',
            'id_kecamatan' => 3,
        ]);

        Desa::create([
            'name' => 'Tegalsiwalan',
            'id_kecamatan' => 3,
        ]);

        Desa::create([
            'name' => 'Tegalsono',
            'id_kecamatan' => 3,
        ]);
    }

}
