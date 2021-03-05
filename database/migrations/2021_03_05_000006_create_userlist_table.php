<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 23-09-2020
 * Time: 06:43 PM
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserlistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $ls     = new \App\Models\UserList();
        Schema::create($ls->table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('');
            $table->string('username')->default('');
            $table->string('email')->default('');
            $table->string('mobile')->default('');
            $table->text('profile_img')->default('');
            $table->date('dob')->default(null);
            $table->text('address')->default('');
            $table->string('city')->default('');
            $table->string('state')->default('');
            $table->string('country')->default('');
            $table->dateTime('updated_at')->useCurrent()->nullable(true);
            $table->dateTime('created_at')->useCurrent()->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $ls     = new \App\Models\UserList();
        Schema::dropIfExists($ls->table);
    }

}