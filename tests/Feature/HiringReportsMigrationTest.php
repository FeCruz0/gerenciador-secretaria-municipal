<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\DirectHire;
use App\Models\DirectHireModality;
use App\Models\DirectHireSituations;
use App\Models\Bidding;
use App\Models\BiddingModality;
use App\Models\BiddingSituation;
use App\Models\BiddingAgreement;
use App\Models\AgreementOrigin;
use App\Models\AgreementType;
use App\Models\AgreementSituation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HiringReportsMigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_hiring_reports_index()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/hiring_reports_index');

        $response->assertStatus(200);
    }
}
