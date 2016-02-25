'use strict';

/**
 * @ngdoc function
 * @name frontendApp.controller:EditoraCtrl
 * @description
 * # EditoraCtrl
 * Controller of the frontendApp
 */
angular.module('frontendApp')
  .controller('EditoraCtrl', function (toastr, $scope, $http, $rootScope) {
    this.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];

    $rootScope.loading = true;
    var vm = this;
    
    vm.editoras;
    vm.pageTitle = 'Cadastrar nova editora';
    
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
        vm.editora = $.param({
              nome: vm.nome,
              email: vm.email,
              telefone: vm.telefone,
        });
        $http.put(api+'/api/editora/' + vm.id, {
          nome: vm.nome,
          email: vm.email,
          telefone: vm.telefone
        })
          .then(function(response){
            console.log(response.data);
            vm.editoras.splice(vm.index, 1);
            vm.editoras.push(response.data);
            toastr.info('Editora '+ response.data.nome + ' atualizada.', 'Sucesso');
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
        } else {
          $http.post(api+'/api/editora', {
            nome: vm.nome,
            telefone: vm.telefone,
            email: vm.email
          })
          .then(function(response){
            vm.editoras.push(response.data);
            toastr.success('Editora '+ response.data.nome + ' inserida.', 'Sucesso');
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
      $http.get(api+'/api/editora/'+id)
      .then(function(response){
        vm.id = id;
        vm.nome = response.data.nome;
        vm.telefone = response.data.telefone;
        vm.email = response.data.email;
        vm.index = index;
        vm.pageTitle = 'Editar Editora';
        vm.update = true;
      }, function(response){
        toastr.error('Erro ao recuperar Editora.','Erro');
      });
    }

    vm.delete = function(id, index){
      $http.delete(api+'/api/editora/'+id)
        .then(function(response){
          toastr.info('Editora '+ response.data.nome + ' removida.','Informação');
          vm.editoras.splice(index, 1);
        },function(response){

      });
    }

 });
