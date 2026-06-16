<?php

use App\Models\SocialMedia;
use App\Models\ConservationUnitType;
use Illuminate\Database\Migrations\Migration;

class Inserts2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @throws Exception
     */
    public function up(): void
    {

        
        $social_media = [
            [   
                'logo' => 'fab fa-instagram',
                'title' => 'Instagram'
            ],
            [   
                'logo' => 'fab fa-facebook',
                'title' => 'FaceBook'
            ],
            [   
                'logo' => 'fab fa-linkedin',
                'title' => 'LinkedIn'
            ],
            [   
                'logo' => 'fab fa-twitter',
                'title' => 'Twitter'
            ],
            [   
                'logo' => 'fab fa-youtube',
                'title' => 'YouTube'
            ],
            [   
                'logo' => 'fab fa-pinterest',
                'title' => 'Pinterest'
            ]
        ];

        foreach ($social_media as $social) {
            SocialMedia::firstOrCreate($social);
        }

        $conservation_unit_types = [
            [   
                'type' => 'Proteção Integral'
            ],
            [   
                'type' => 'Uso Estável'
            ]
            
        ];

        foreach ($conservation_unit_types as $conservation_unit_type) {
            ConservationUnitType::firstOrCreate($conservation_unit_type);
        }

    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
    }
}
