<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateMpesaTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('ekale_mpesa_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->string('phone');
            $table->decimal('amount', 10, 2);
            $table->string('reference');
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mpesa_transactions');
    }
}