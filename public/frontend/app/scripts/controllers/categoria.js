'use strict';

/**
 * @ngdoc function
 * @name frontendApp.controller:CategoriaCtrl
 * @description
 * # CategoriaCtrl
 * Controller of the frontendApp
 */
angular.module('frontendApp')
  .controller('CategoriaCtrl', function (toastr, $scope, $http, $rootScope) {
    this.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];

    $rootScope.loading = true;
    var vm = this;
    
    vm.categorias;
    vm.pageTitle = 'Cadastrar nova categoria';
    
    vm.nome;
    vm.telefone;
    vm.email;
    vm.update = false;

    vm.erros;

    vm.clear = function(){
      vm.nome = null;
      vm.email = null;
      vm.telefone = null;
    }

    $http.get(api+'/api/categoria')
    .then(function(response){
    	console.log(response.data);
    	vm.categorias = response.data;
      $rootScope.loading = false;
    },function(response){
    	vm.error = response.data;
  	});

    vm.store = function(){
      if(vm.update){
        vm.categoria = $.param({
              nome: vm.nome,
        });
        $http.put(api+'/api/categoria/' + vm.id, {
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
          $http.post(api+'/api/categoria', {
            nome: vm.nome
          })
          .then(function(response){
            vm.categorias.push(response.data);
            toastr.success('Categoria '+ response.data.nome + ' inserida.', 'Sucesso');
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
      $http.get(api+'/api/categoria/'+id)
      .then(function(response){
        vm.id = id;
        vm.nome = response.data.nome;
        vm.index = index;
        vm.pageTitle = 'Editar Categoria';
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
