<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConservationUnitCoverageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conservation_unit_coverage', function (Blueprint $table) {
                $table->id();
                $table->foreignId('conservation_unit_id')->constrained('conservation_units');
                $table->foreignId('coverage_id')->constrained('coverages');
                $table->timestamps();
                $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conservation_unit_coverage');
    }
}
