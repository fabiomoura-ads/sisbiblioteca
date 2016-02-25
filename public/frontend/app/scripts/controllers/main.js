'use strict';

/**
 * @ngdoc function
 * @name frontendApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the frontendApp
 */
angular.module('frontendApp')
  .controller('MainCtrl', function ($http, $rootScope) {
    this.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];

    var vm = this;
    $rootScope.loading = true;
    //Quantidade Geral
    $http.get(api+'/api/main')
    .then(function(response){
    	vm.all = response.data;
    	$rootScope.loading = false;
    });

    $rootScope.data = [300, 200];
    $rootScope.labels = ['Categorias', 'Editoras'];
    

  });
