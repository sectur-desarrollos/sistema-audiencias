<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            ["id" => 1, "name" => "Aguascalientes", "activo" => true],
            ["id" => 2, "name" => "Baja California", "activo" => true],
            ["id" => 3, "name" => "Baja California Sur", "activo" => true],
            ["id" => 4, "name" => "Campeche", "activo" => true],
            ["id" => 5, "name" => "Coahuila", "activo" => true],
            ["id" => 6, "name" => "Colima", "activo" => true],
            ["id" => 7, "name" => "Chiapas", "activo" => true],
            ["id" => 8, "name" => "Chihuahua", "activo" => true],
            ["id" => 9, "name" => "Ciudad de México", "activo" => true],
            ["id" => 10, "name" => "Durango", "activo" => true],
            ["id" => 11, "name" => "Guanajuato", "activo" => true],
            ["id" => 12, "name" => "Guerrero", "activo" => true],
            ["id" => 13, "name" => "Hidalgo", "activo" => true],
            ["id" => 14, "name" => "Jalisco", "activo" => true],
            ["id" => 15, "name" => "Estado de México", "activo" => true],
            ["id" => 16, "name" => "Michoacán", "activo" => true],
            ["id" => 17, "name" => "Morelos", "activo" => true],
            ["id" => 18, "name" => "Nayarit", "activo" => true],
            ["id" => 19, "name" => "Nuevo León", "activo" => true],
            ["id" => 20, "name" => "Oaxaca", "activo" => true],
            ["id" => 21, "name" => "Puebla", "activo" => true],
            ["id" => 22, "name" => "Querétaro", "activo" => true],
            ["id" => 23, "name" => "Quintana Roo", "activo" => true],
            ["id" => 24, "name" => "San Luis Potosí", "activo" => true],
            ["id" => 25, "name" => "Sinaloa", "activo" => true],
            ["id" => 26, "name" => "Sonora", "activo" => true],
            ["id" => 27, "name" => "Tabasco", "activo" => true],
            ["id" => 28, "name" => "Tamaulipas", "activo" => true],
            ["id" => 29, "name" => "Tlaxcala", "activo" => true],
            ["id" => 30, "name" => "Veracruz", "activo" => true],
            ["id" => 31, "name" => "Yucatán", "activo" => true],
            ["id" => 32, "name" => "Zacatecas", "activo" => true],
        ];

        DB::table('states')->insert($states);
    }
}
