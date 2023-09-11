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
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->morphs('addressable');
            $table->string('label')->nullable();
            $table->string('company')->nullable();
            $table->foreignId('country_id')->on('countries')->nullable();
            $table->foreignId('state_id')->on('states')->nullable();
            $table->string('state_name')->nullable();
            $table->foreignId('city_id')->on('cities')->nullable();
            $table->string('city_name')->nullable();
            $table->string('line1')->nullable();
            $table->string('line2')->nullable();
            $table->string('street')->nullable();
            $table->string('postal_code')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->boolean('is_primary')->default(false);
            $table->boolean('is_billing')->default(false);
            $table->boolean('is_shipping')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists(config('laravel-address.tables.addresses'));
    }
}