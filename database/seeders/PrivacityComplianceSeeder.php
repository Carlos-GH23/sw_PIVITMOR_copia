<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ConsentConfiguration;
use App\Models\PrivacityCompliance;

class PrivacityComplianceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ConsentConfiguration::create([
            'data_usage_consent' => true,
            'force_acceptance' => true,
            'electronic_communication_consent' => true,
            'electronic_communication_message' => 'We would like to send you electronic communications.',
            'statistical_data_consent' => true,
            'statistical_data_message' => 'We would like to collect statistical data.',
            'frequency_of_acceptance' => 'annually',
        ]);

        PrivacityCompliance::create([
            'version' => 4.0,
            'privacity_advice' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

Curabitur pretium tincidunt lacus. Nulla gravida orci a odio. Nullam varius, turpis et commodo pharetra, est eros bibendum elit, nec luctus magna felis sollicitudin mauris. Integer in mauris eu nibh euismod gravida. Duis ac tellus et risus vulputate vehicula. Donec lobortis risus a elit. Etiam tempor. Ut ullamcorper, ligula eu tempor congue, eros est euismod turpis, id tincidunt sapien risus a quam. Maecenas fermentum consequat mi. Donec fermentum. Pellentesque malesuada nulla a mi. Duis sapien sem, aliquet nec, commodo eget, consequat quis, neque. Aliquam faucibus, elit ut dictum aliquet, felis nisl adipiscing sapien, sed malesuada diam lacus eget erat. Cras mollis scelerisque nunc. Nullam arcu. Aliquam consequat. Curabitur augue lorem, dapibus quis, laoreet et, pretium ac, nisi. Aenean magna nisl, mollis quis, molestie eu, feugiat in, orci. In hac habitasse platea dictumst.

Fusce convallis metus id felis luctus adipiscing. Pellentesque egestas, neque sit amet convallis pulvinar, justo nulla eleifend augue, ac auctor orci leo non est. Quisque id mi. Ut tincidunt, ante vel scelerisque iaculis, quam metus vestibulum massa, sit amet lacinia arcu quam a nibh. Quisque id justo. In molestie, tellus non tincidunt placerat, velit sem cursus nunc, quis pharetra tortor leo id libero. Nunc et libero eget leo imperdiet ultricies. Suspendisse potenti. Ut sed lectus. Integer vel massa. Maecenas a ipsum. Curabitur facilisis. Nam interdum, nisl blandit mollis bibendum, turpis nisl dignissim lacus, sit amet elementum nulla sem nec tortor. Nunc porttitor.

Proin cursus. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.',
            'is_active' => true
        ]);

        PrivacityCompliance::create([
            'version' => 3.0,
            'privacity_advice' => 'Este es nuestro aviso de privacidad...',
            'is_active' => false
        ]);

        PrivacityCompliance::create([
            'version' => 2.0,
            'privacity_advice' => 'Este es nuestro aviso de privacidad...',
            'is_active' => false
        ]);

        PrivacityCompliance::create([
            'version' => 3.5,
            'privacity_advice' => 'Este es nuestro aviso de privacidad...',
            'is_active' => false
        ]);

        PrivacityCompliance::create([
            'version' => 1.0,
            'privacity_advice' => 'Este es nuestro aviso de privacidad...',
            'is_active' => false
        ]);
    }
}
