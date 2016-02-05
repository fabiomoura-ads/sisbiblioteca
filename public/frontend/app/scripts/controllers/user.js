'use strict';

/**
 * @ngdoc function
 * @name frontendApp.controller:UserCtrl
 * @description
 * # UserCtrl
 * Controller of the frontendApp
 */
angular.module('frontendApp')
  .controller('UserCtrl', function ($auth, $state, $http, $rootScope, toastr) {
    this.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];

    var vm = this;

    vm.loginError = false;
    vm.loginErrorText;

    vm.login = function() {

    var credentials = {
        email: vm.email,
        password: vm.password
    }

            $auth.login(credentials).then(function() {

                // Return an $http request for the now authenticated
                // user so that we can flatten the promise chain
                return $http.get(api+'/api/authenticate/user');

            // Handle errors
            }, function(error) {
                vm.loginError = true;
                vm.loginErrorText = error.data.error;

            // Because we returned the $http.get request in the $auth.login
            // promise, we can chain the next promise to the end here
            }).then(function(response) {

                // Stringify the returned data to prepare it
                // to go into local storage
                var user = JSON.stringify(response.data.user);

                // Set the stringified user data into local storage
                localStorage.setItem('user', user);

                // The user's authenticated state gets flipped to
                // true so we can now show parts of the UI that rely
                // on the user being logged in
                $rootScope.authenticated = true;

                // Putting the user's data on $rootScope allows
                // us to access it anywhere across the app
                $rootScope.currentUser = response.data.user;

                // Everything worked out so we can now redirect to
                // the users state to view the data
                $state.go('main');
            });
        }

        
        vm.users;
        vm.error;

        vm.getUsers = function() {

            // This request will hit the index method in the AuthenticateController
            // on the Laravel side and will return the list of users
            $http.get(api+'/api/authenticate').success(function(users) {
                vm.users = users;
            }).error(function(error) {
            	toastr.error(error.error, 'Error');
                vm.error = error;
            });
        }


        vm.logout = function() {

            $auth.logout().then(function() {

                // Remove the authenticated user from local storage
                localStorage.removeItem('user');

                // Flip authenticated to false so that we no longer
                // show UI elements dependant on the user being logged in
                $rootScope.authenticated = false;

                // Remove the current user info from rootscope
                $rootScope.currentUser = null;
            });
        }





  });
