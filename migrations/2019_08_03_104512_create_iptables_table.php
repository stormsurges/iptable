<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateIptablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iptables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('StartIPNum')->nullable();
            $table->string('StartIPText')->nullable();
            $table->double('EndIPNum')->nullable();
            $table->string('EndIPText')->nullable();
            $table->string('Country')->nullable();
            $table->string('Local')->nullable();
        });

        $this->seeder();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iptables');
    }

    public function seeder()
    {
        ini_set('memory_limit', '250M'); //内存限制
        set_time_limit(0);
        $sql = file_get_contents(__DIR__ . '/iptables.sql');
        DB::unprepared($sql);
    }
}
