<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB; //X, creacion de numero cliente

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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->string('direccion');
            $table->string('notas');
            $table->string('photo');

            $table->string('customer_number')->unique();//X, creacion de numero cliente

            $table->timestamps();
        });

        //X, creacion de numero cliente
        $orders = DB::table('orders')->get();
        foreach ($orders as $order) {
            $customerNumber = $this->generateUniqueCustomerNumber();
            DB::table('orders')
                ->where('id', $order->id)
                ->update(['customer_number' => $customerNumber]);
        }
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

    //X, creacion de numero cliente
    private function generateUniqueCustomerNumber()
    {
        $customerNumber = mt_rand(1000000000, 9999999999);
        while (DB::table('orders')->where('customer_number', $customerNumber)->exists()) {
            $customerNumber = mt_rand(1000000000, 9999999999);
        }
        return $customerNumber;
    }
};
