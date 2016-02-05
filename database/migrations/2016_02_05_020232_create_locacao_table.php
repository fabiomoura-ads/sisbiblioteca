<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("locacoes", function(Blueprint $table){
			$table->increments("id");
			$table->integer("aluno_id")->unsigned();
			$table->foreign("aluno_id")->references("id")->on("alunos");
			$table->integer("livro_id")->unsigned();
			$table->foreign("livro_id")->references("id")->on("livros");
			$table->date("data_locacao");
			$table->date("data_devolucao");
			$table->boolean("status")->default(true);					
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("locacoes");
    }
}
