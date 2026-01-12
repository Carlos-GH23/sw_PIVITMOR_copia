<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Institution\Department;

class DepartmentSeeder extends Seeder
{
	public function run()
	{

		Department::create([
			'name' => 'DEPARTAMENTO DE CIENCIAS COMPUTACIONALES',
			'description' => 'Departamento enfocado en el estudio y desarrollo de tecnologías de la información, programación y sistemas computacionales.',
			'is_active' => true,
			'institution_id' => 1,
		]);
		Department::create([
			'name' => 'DEPARTAMENTO DE INGENIERÍA ELECTRÓNICA',
			'description' => 'Departamento dedicado a la formación y desarrollo en circuitos, sistemas electrónicos y automatización.',
			'is_active' => true,
			'institution_id' => 1,
		]);
		Department::create([
			'name' => 'DEPARTAMENTO DE INGENIERÍA MECÁNICA',
			'description' => 'Departamento especializado en diseño, análisis y manufactura de sistemas mecánicos y térmicos.',
			'is_active' => true,
			'institution_id' => 1,
		]);
		Department::create([
			'name' => 'DEPARTAMENTO DE INGENIERÍA MECATRÓNICA',
			'description' => 'Departamento que integra conocimientos de mecánica, electrónica y computación para el desarrollo de sistemas automatizados.',
			'is_active' => true,
			'institution_id' => 1,
		]);
		Department::create([
			'name' => 'DEPARTAMENTO DE CIENCIAS DE LA INGENIERÍA',
			'description' => 'Departamento orientado a la investigación y docencia en las ciencias básicas aplicadas a la ingeniería.',
			'is_active' => false,
			'institution_id' => 1,
		]);

		Department::create([
			'name' => 'DEPARTAMENTO DE CIENCIAS COMPUTACIONALES',
			'description' => 'Departamento enfocado en el estudio y desarrollo de tecnologías de la información, programación y sistemas computacionales.',
			'is_active' => true,
			'institution_id' => 2,
		]);
		Department::create([
			'name' => 'DEPARTAMENTO DE INGENIERÍA ELECTRÓNICA',
			'description' => 'Departamento dedicado a la formación y desarrollo en circuitos, sistemas electrónicos y automatización.',
			'is_active' => true,
			'institution_id' => 3,
		]);
		Department::create([
			'name' => 'DEPARTAMENTO DE INGENIERÍA MECÁNICA',
			'description' => 'Departamento especializado en diseño, análisis y manufactura de sistemas mecánicos y térmicos.',
			'is_active' => true,
			'institution_id' => 4,
		]);
		Department::create([
			'name' => 'DEPARTAMENTO DE INGENIERÍA MECATRÓNICA',
			'description' => 'Departamento que integra conocimientos de mecánica, electrónica y computación para el desarrollo de sistemas automatizados.',
			'is_active' => true,
			'institution_id' => 5,
		]);
		Department::create([
			'name' => 'DEPARTAMENTO DE CIENCIAS COMPUTACIONALES',
			'description' => 'Departamento enfocado en el estudio y desarrollo de tecnologías de la información, programación y sistemas computacionales.',
			'is_active' => true,
			'institution_id' => 6,
		]);
		Department::create([
			'name' => 'DEPARTAMENTO DE INGENIERÍA ELECTRÓNICA',
			'description' => 'Departamento dedicado a la formación y desarrollo en circuitos, sistemas electrónicos y automatización.',
			'is_active' => true,
			'institution_id' => 7,
		]);
		Department::create([
			'name' => 'DEPARTAMENTO DE INGENIERÍA MECÁNICA',
			'description' => 'Departamento especializado en diseño, análisis y manufactura de sistemas mecánicos y térmicos.',
			'is_active' => true,
			'institution_id' => 8,
		]);
	}
}
