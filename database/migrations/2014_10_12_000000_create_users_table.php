<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('user_id');
            $table->string('user_nm');
            $table->string('user_tp')->default('USER_TP_2');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->text('image')->nullable();
            $table->boolean('active')->default(false);
            $table->string('tbl_company_id')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->primary('user_id');

            /* $table->foreign('tbl_company_id')
                ->references('tbl_company_id')
                ->on('tbl_company')
                ->onDelete('cascade'); */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
