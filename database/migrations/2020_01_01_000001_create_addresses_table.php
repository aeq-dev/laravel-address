<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    public function up()
    {
        Schema::create(config('laravel-address.tables.addresses'), function (Blueprint $table) {
            // Columns
            $table->increments('id');
            $table->morphs('addressable');
            $table->string('label')->nullable();
            $table->string('country_code', 2)->nullable();
            $table->string('street')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists(config('laravel-address.tables.addresses'));
    }
}