<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentsTable extends Migration
{
    /**
     * Run the migrations to create the shipments table in MySQL.
     */
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();$table->string('shipment_code')->unique(); 
            $table->string('driver_name');$table->string('route_path');               
            $table->string('estimated_arrival');$table->string('status');                   
            $table->string('meta_info')->nullable();$table->string('phone_number')->nullable();             
            $table->string('origin_address');$table->string('destination_address');      
            $table->string('cargo_details');$table->integer('quantity');                
            $table->string('payment_status');$table->decimal('delivery_cost', 10, 2);    
            $table->string('schedule_category');$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('shipments');
    }
}