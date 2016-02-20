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
      $http.post(api+'/api/editora', {
        nome: vm.nome,
        telefone: vm.telefone,
        email: vm.email
      })
      .then(function(status, response){
        console.log(status);
        vm.editoras.push(response.data);

        toastr.success('Editora '+ response.data.nome + ' inserida.', 'Sucesso');
        vm.clear();
      }, function(response){
        
        vm.error = response.data;
        console.log(vm.error);
        
        $.each(vm.error, function(key, item) {
          $.each(item, function(nome, msg) {
            toastr.error(nome+': '+msg, 'Erro');
          });
        });

      });      
    }

    vm.validation = function(){
      
    }

 });
