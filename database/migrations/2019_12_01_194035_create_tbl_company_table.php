<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_company', function (Blueprint $table) {
            $table->string('tbl_company_id');
            $table->string('company_nm',200);
            $table->string('company_tp',20)->nullable();
            $table->string('company_root')->nullable();
            $table->text('company_address')->nullable();
            $table->string('phone',20)->nullable();
            $table->string('notif_url',100)->nullable();
            $table->string('notif_token_1',100)->nullable();
            $table->string('notif_token_2',100)->nullable();
            $table->string('notif_token_3',100)->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->primary('tbl_company_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_company');
    }
}
