<?php

namespace Database\Seeders;

use App\Models\NonProfitOrganization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NonProfitOrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NonProfitOrganization::create([
            'name' => 'ONG de prueba',
            'description' => 'Labore velit deserunt deserunt ut nisi cillum voluptate sunt quis. Pariatur sunt nostrud ad minim velit aute ex. Aliquip cupidatat sunt et ex cupidatat nisi ut. Exercitation esse aliqua ullamco ad culpa quis consectetur ad dolore qui occaecat. Cupidatat qui duis dolore laborum labore.',
            'mission' => 'Ullamco deserunt proident magna incididunt officia exercitation nostrud pariatur consequat sunt quis mollit aliqua. Sint officia est ad nulla mollit anim consequat et non ad. Ea amet et ad aute nostrud ipsum est commodo enim non voluptate. Ut ipsum magna sint proident Lorem do qui exercitation exercitation adipisicing duis occaecat velit occaecat.',
            'main_projects' => 'Tempor deserunt culpa enim labore velit duis voluptate cupidatat id sint. Aliqua magna officia nostrud duis. Do consectetur laboris tempor dolore magna tempor nisi anim adipisicing ipsum duis. Excepteur pariatur excepteur sunt eu culpa incididunt. Ex aute tempor cupidatat aute non aliqua.',
            'cluni' => '',
            'rfc' => 'ongtest123456789',
            'legal_representative' => 'Miguel Pérez Pérez',
            'economic_sector_id' => 1,
            'legal_entity_type_id' => 1,
            'market_reach_id' => 1,
            'user_id' => 5,
        ]);
    }
}
