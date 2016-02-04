<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlunoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("alunos", function(Blueprint $table){
			$table->increments("id");
			$table->string("matricula")->unique();
			$table->string("nome", 150);
			$table->string("email");
			$table->string("telefone");
			$table->boolean("status")->default(true);
			$table->timestamps();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("alunos");
    }
}
