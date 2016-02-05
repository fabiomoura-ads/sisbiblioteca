'use strict';

/**
 * @ngdoc function
 * @name frontendApp.controller:AboutCtrl
 * @description
 * # AboutCtrl
 * Controller of the frontendApp
 */
angular.module('frontendApp')
  .controller('AboutCtrl', function ($scope,$http,toastr) {
    this.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];

    toastr.success('Hello world!', 'Toastr fun!');
    var vm = this;
    vm.nameModal = 'Novo Post';

    vm.posts = [
    {
      "id": 1,
      "title": "Titulo 1",
      "content": "Conteudo 1",
    },
    {
      "id": 2,
      "title": "Titulo 2",
      "content": "Conteudo 1",
    },
    {
      "id": 3,
      "title": "Titulo 3",
      "content": "Conteudo 1",
    }
    ];
    
    vm.store = function(){
      alert("dsada");
    }

    vm.teste = function(){
      alert(vm.file);
    }

    vm.edit = function(id){
      vm.title = "Primeiro Título";
      vm.content = "Content";
    }

    vm.cancel = function(){
      vm.title = null;
      vm.content = null;
    }

    vm.delete = function(id){
    
        alert("dsa");

        vm.posts.forEach(function(result, index) {
          if(result[property] === value) {
            //Remove from array
            array.splice(index, 1);
          }    
        });
    
    
      
    }

  });


 angular.module('frontendApp')
  .controller('CrudAbout', function ($scope, $uibModalInstance) {
    	
  $scope.ok = function () {
    //$uibModalInstance.close($scope.selected.item);
    alert($scope.title);
  };

  $scope.cancel = function () {
    $uibModalInstance.dismiss('cancel');
  };


  });
