<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queues', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('user_id')->comment('member id');
            $table->uuid('department_id')->comment('departments id');
            $table->uuid('service_id')->comment('departments service id');
            $table->unsignedBigInteger('officer_id')->comment('petugas id');
            $table->smallInteger('data_from')->default(0)->comment('0 from office; 1 from website; 2 from mobile android; 3 from mobile ios');
            $table->integer('counter');
            $table->date('check_in_date');
            $table->time('check_in_time');
            $table->time('max_check_in_time');
            $table->time('queue_call_time')->nullable()->default(null);
            $table->time('queue_done_time')->nullable()->default(null);
            $table->smallInteger('queue_status')->default(1)->comment('1 belum dilayani; 2 sudah dilayani; 3 Pending; 4 Batal;');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('department_services')->onDelete('cascade');
            $table->foreign('officer_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'department_id', 'service_id', 'officer_id']);
            $table->unique(['department_id', 'counter', 'check_in_date'], 'queuestreeunique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('queues');
    }
}
