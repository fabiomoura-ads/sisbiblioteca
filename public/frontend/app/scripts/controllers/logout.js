'use strict';

/**
 * @ngdoc function
 * @name frontendApp.controller:LogoutCtrl
 * @description
 * # LogoutCtrl
 * Controller of the frontendApp
 */
angular.module('frontendApp')
  .controller('LogoutCtrl', function ($auth, $state, $http, $rootScope) {
    this.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];


    $auth.logout().then(function() {

        // Remove the authenticated user from local storage
        localStorage.removeItem('user');

        // Flip authenticated to false so that we no longer
        // show UI elements dependant on the user being logged in
        $rootScope.authenticated = false;

    	// Remove the current user info from rootscope
        $rootScope.currentUser = null;

        $state.go('login');
    });


  });
