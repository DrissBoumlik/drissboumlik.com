<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('ip')->nullable(); //: "105.158.165.210"
            $table->string('countryName')->nullable(); //: "Morocco"
            $table->string('countryCode')->nullable(); //: "MA"
            $table->string('regionCode')->nullable(); //: "04"
            $table->string('regionName')->nullable(); //: "Rabat-Sale-Kenitra"
            $table->string('cityName')->nullable(); //: "Salé"
            $table->string('zipCode')->nullable(); //: ""
            $table->string('isoCode')->nullable(); //: null
            $table->string('postalCode')->nullable(); //: null
            $table->string('latitude')->nullable(); //: "34.0531"
            $table->string('longitude')->nullable(); //: "-6.7985"
            $table->string('metroCode')->nullable(); //: null
            $table->string('areaCode')->nullable(); //: "04"
            $table->string('timezone')->nullable(); //: "Africa/Casablanca"
            $table->string('driver')->nullable(); //: "Stevebauman\Location\Drivers\IpApi"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitors');
    }
};
