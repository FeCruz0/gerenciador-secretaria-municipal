<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConservationUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conservation_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conservation_unit_type_id')->constrained('conservation_unit_types');
            $table->string('title');
            $table->string('creation');
            $table->string('creation_link');
            $table->text('objective')->nullable();
            $table->string('area');
            $table->string('localization');
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->string('opening_hours');
            $table->string('thumb')->nullable();
            $table->string('thumb_description')->nullable();
            $table->enum('status', ['PUBLISHED', 'DRAFT', 'PENDING'])->default('DRAFT');
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
        Schema::dropIfExists('conservation_units');
    }
}
