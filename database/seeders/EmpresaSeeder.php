<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empresa;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
        $empresa = [
            [
                'NIT'                => '1111111',
                'razon_social'       => 'Help!Humano',
                'numero_contacto'    => '0000000',
                'correo_electronico' => 'info@helpdigital.com.co',
                'direccion_fisica'   => 'Cr 00 #00-00',
                'frecuencia_id'      => 1
            ],
            [
                'NIT'                => '9017429812',
                'razon_social'       => 'Empresa Test 01',
                'numero_contacto'    => '3105343272',
                'correo_electronico' => 'empresa01@test.com',
                'direccion_fisica'   => 'CARRERA 40 A 7 51 A OFICINA 1506',
                'frecuencia_id'      => 2,
            ],
                        
        ];

        Empresa::insert($empresa);
    }
}
