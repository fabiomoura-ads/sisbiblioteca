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
    
    vm.livros;
    vm.categorias;
    vm.editoras;
    vm.pageTitle = 'Cadastrar Livro';
    
    vm.update = false;

    vm.erros;

    vm.clear = function(){
      vm.codigo = null;
      vm.titulo = null;
      vm.autor = null;
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
        vm.livro = $.param({
              codigo: vm.codigo,
              titulo: vm.titulo,
              autor: vm.autor,
              categoria_id: vm.categoria,
              editora_id: vm.editora,
        });

        $http.put(api+'/api/livro/' + vm.id, {
            codigo: vm.codigo,
            titulo: vm.titulo,
            autor: vm.autor,
            categoria_id: vm.categoria,
            editora_id: vm.editora
        })
          .then(function(response){
            console.log(response.data);
            vm.livros.splice(vm.index, 1);
            vm.livros.push(response.data);
            toastr.info('Livro '+ response.data.titulo + ' atualizada.', 'Sucesso');
            vm.clear();
            $("#myModal").modal('hide');
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
        toastr.error('Erro ao recuperar Livro.','Erro');
      });
    }

    vm.delete = function(id, index){
      $http.delete(api+'/api/livro/'+id)
        .then(function(response){
          toastr.info('Livro '+ response.data.titulo + ' removida.','Informação');
          vm.livros.splice(index, 1);
        },function(response){

      });
    }

  });
