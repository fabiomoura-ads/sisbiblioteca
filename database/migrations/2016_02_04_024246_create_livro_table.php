<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLivroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("livros", function(Blueprint $table){
			$table->increments("id");
			$table->string("codigo")->unique();
			$table->string("titulo", 150);
			$table->string("autor", 150);
			$table->string("descricao");
			$table->integer("num_pag");
			$table->integer("editora_id")->unsigned();
			$table->foreign("editora_id")->references("id")->on("editoras")->onDelete("restrict");
			$table->integer("categoria_id")->unsigned();
			$table->foreign("categoria_id")->references("id")->on("categorias")->onDelete("restrict");			
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
        Schema::drop("livros");
    }
}
