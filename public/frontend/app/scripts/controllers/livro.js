'use strict';

/**
 * @ngdoc function
 * @name frontendApp.controller:LivroCtrl
 * @description
 * # LivroCtrl
 * Controller of the frontendApp
 */
angular.module('frontendApp')
  .controller('LivroCtrl', function (toastr, $scope, $http, $rootScope) {
    this.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];

    $rootScope.loading = true;
    var vm = this;
    
    vm.categorias;
    vm.pageTitle = 'Cadastrar Livro';
    
    vm.nome;
    vm.telefone;
    vm.email;
    vm.update = false;

    vm.erros;

    vm.clear = function(){
      vm.nome = null;
    }

    $http.get(api+'/api/livro')
    .then(function(response){
    	console.log(response.data);
    	vm.livros = response.data;
      $rootScope.loading = false;
    },function(response){
    	vm.error = response.data;
  	});

    //Get all Categoria
  	$http.get(api+'/api/categoria')
    .then(function(response){
    	console.log(response.data);
    	vm.categorias = response.data;
      $rootScope.loading = false;
    },function(response){
    	vm.error = response.data;
  	});

  	//Get all Editora
  	$http.get(api+'/api/editora')
    .then(function(response){
    	console.log(response.data);
    	vm.editoras = response.data;
      $rootScope.loading = false;
    },function(response){
    	vm.error = response.data;
  	});

    vm.store = function(){
      if(vm.update){
        vm.categoria = $.param({
              codigo: vm.codigo,
              titulo: vm.titulo,
              autor: vm.autor,
              categoria: vm.categoria,
              editora: vm.editora,
        });
        $http.put(api+'/api/livro/' + vm.id, {
          nome: vm.nome,
        })
          .then(function(response){
            console.log(response.data);
            vm.categorias.splice(vm.index, 1);
            vm.categorias.push(response.data);
            toastr.info('Editora '+ response.data.nome + ' atualizada.', 'Sucesso');
            vm.clear();
            vm.update = false;
          }, function(response){
            vm.error = response.data;
            console.log(vm.error);
            $.each(vm.error, function(key, item) {
              $.each(item, function(nome, msg) {
                toastr.error(msg, 'Erro');
              });
            });
          });
        } else {
        	//Create
        	alert(vm.editora);
          $http.post(api+'/api/livro', {
            codigo: vm.codigo,
            titulo: vm.titulo,
            autor: vm.autor,
            categoria_id: vm.categoria,
            editora_id: vm.editora,
          })
          .then(function(response){
            vm.livros.push(response.data);
            toastr.success('Livro '+ response.data.titulo + ' inserido.', 'Sucesso');
            vm.clear();
          }, function(response){
            vm.error = response.data;
            console.log(vm.error);
            $.each(vm.error, function(key, item) {
              $.each(item, function(nome, msg) {
                toastr.error(msg, 'Erro');
              });
            });
          }); 
        }//end If


    }



    vm.validation = function(){
    }

    vm.edit = function(id, index){
      $http.get(api+'/api/livro/'+id)
      .then(function(response){
        vm.id = id;
        
        vm.codigo = response.data.codigo;
        vm.titulo = response.data.titulo;
        vm.autor = response.data.autor;
        vm.categoria = response.data.categoria;
        vm.editora = response.data.editora;

        vm.index = index;
        vm.pageTitle = 'Editar Livro';
        vm.update = true;

      }, function(response){
        toastr.error('Erro ao recuperar Editora.','Erro');
      });
    }

    vm.delete = function(id, index){
      $http.delete(api+'/api/categoria/'+id)
        .then(function(response){
          toastr.info('Categoria '+ response.data.nome + ' removida.','Informação');
          vm.categorias.splice(index, 1);
        },function(response){

      });
    }

  });
