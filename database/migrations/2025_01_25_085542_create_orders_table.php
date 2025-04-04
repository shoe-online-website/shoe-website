<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('phone', 20);
            $table->string('province', 20);
            $table->string('district', 20);
            $table->string('ward', 20);
            $table->string('email', 100);
            $table->string('note', 100);

            $table->float('total', 10);
            $table->float('discount', 10)->default(0);
            $table->string('coupon_code', 100)->nullable();
            $table->integer('order_status_id')->unsigned()->nullable();
            $table->timestamp('payment_complete_date');
            $table->timestamps();
            
            $table->foreign('order_status_id')->references('id')->on('orders_status')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
