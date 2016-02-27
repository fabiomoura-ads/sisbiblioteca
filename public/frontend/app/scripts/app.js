'use strict';

/**
 * @ngdoc overview
 * @name frontendApp
 * @description
 * # frontendApp
 *
 * Main module of the application.
 */

var api = 'http://localhost:8090';

angular
  .module('frontendApp', [
    'ngAnimate',
    'ngCookies',
    'ngResource',
    'ngSanitize',
    'ngTouch',
    'ui.bootstrap',
    'mwl.confirm',
    'ui.router',
    'satellizer',
    'toastr',
    'flow',
    'angularUtils.directives.dirPagination',
    'ui.mask'
  ])
  .config(function ($stateProvider, $urlRouterProvider, $authProvider, $httpProvider, $provide){ 

      function redirectWhenLoggedOut($q, $injector) {
        
        return {
          responseError: function(rejection) {
            // Need to use $injector.get to bring in $state or else we get
            // a circular dependency error
            var $state = $injector.get('$state');
            // Instead of checking for a status code of 400 which might be used
            // for other reasons in Laravel, we check for the specific rejection
            // reasons to tell us if we need to redirect to the login state
            var rejectionReasons = ['token_not_provided', 'token_expired', 'token_absent', 'token_invalid'];
            // Loop through each rejection reason and redirect to the login
            // state if one is encountered
            angular.forEach(rejectionReasons, function(value, key) {

              if(rejection.data.error === value) {

                // If we get a rejection corresponding to one of the reasons
                // in our array, we know we need to authenticate the user so 
                // we can remove the current user from local storage
                localStorage.removeItem('user');

                // Send the user to the auth state so they can login
                $state.go('login');
              }
            });

            return $q.reject(rejection);
          }
        }
      }
      //EndredirectWhenLoggedOut

      // Setup for the $httpInterceptor
      $provide.factory('redirectWhenLoggedOut', redirectWhenLoggedOut);
      // Push the new factory onto the $http interceptor array
      $httpProvider.interceptors.push('redirectWhenLoggedOut');

      $authProvider.loginUrl = api+'/api/authenticate';

      $urlRouterProvider.otherwise('/');

  //stateProvider
  $stateProvider
    .state('main', {
      url: '/',
      templateUrl: 'views/main.html',
      controller: 'MainCtrl as main',
      resolve: {
        loginRequired: loginRequired
      }
    })
    .state('about', {
      url: '/about',
      templateUrl: 'views/about.html',
      controller: 'AboutCtrl as about',
      resolve: {
        loginRequired: loginRequired
      }
    })
    .state('editora', {
      url: '/editora',
      templateUrl: 'views/editora.html',
      controller: 'EditoraCtrl as editora',
      resolve: {
        loginRequired: loginRequired
      }
    })
    .state('categoria', {
      url: '/categoria',
      templateUrl: 'views/categoria.html',
      controller: 'CategoriaCtrl as categoria',
      resolve: {
        loginRequired: loginRequired
      }
    })
    .state('livro', {
      url: '/livro',
      templateUrl: 'views/livro.html',
      controller: 'LivroCtrl as livro',
      resolve: {
        loginRequired: loginRequired
      }
    })
    .state('login', {
      url: '/login',
      templateUrl: 'views/user.html',
      controller: 'UserCtrl as user',
      resolve:{
        skipIfLoggedIn: skipIfLoggedIn
      }
    })
    .state('logout', {
      url: '/logout',
      templateUrl: 'views/logout.html',
      controller: 'LogoutCtrl as logout',
      resolve: {
        loginRequired: loginRequired
      }
    });

    //SkipIfLoggedIn
    function skipIfLoggedIn($q, $auth) {
      var deferred = $q.defer();
      if ($auth.isAuthenticated()) {
        deferred.reject();
      } else {
        deferred.resolve();
      }
      return deferred.promise;
    }
    //loginRequired
    function loginRequired($q, $location, $auth, $rootScope) {
      var deferred = $q.defer();
      if ($auth.isAuthenticated()) {
        //if($rootScope.authenticated){
        deferred.resolve();
      } else {
        $rootScope.authenticated = false;
        localStorage.removeItem('user');
        $location.path('/login');
      }
      return deferred.promise;
    }
    //End
  
}).run(function($rootScope, $state) {

      // $stateChangeStart is fired whenever the state changes. We can use some parameters
      // such as toState to hook into details about the state as it is changing
      $rootScope.$on('$stateChangeStart', function(event, toState) {
  
        // Grab the user from local storage and parse it to an object
        var user = JSON.parse(localStorage.getItem('user'));            
        // If there is any user data in local storage then the user is quite
        // likely authenticated. If their token is expired, or if they are
        // otherwise not actually authenticated, they will be redirected to
        // the auth state because of the rejected request anyway
        if(user) {
          // The user's authenticated state gets flipped to
          // true so we can now show parts of the UI that rely
          // on the user being logged in
          $rootScope.authenticated = true;
          // Putting the user's data on $rootScope allows
          // us to access it anywhere across the app. Here
          // we are grabbing what is in local storage
          $rootScope.currentUser = user;
          // If the user is logged in and we hit the auth route we don't need
          // to stay there and can send the user to the main state
          if(toState.name === "auth") {
            // Preventing the default behavior allows us to use $state.go
            // to change states
            event.preventDefault();
            // go to the "main" state which in our case is users
            $state.go('users');
          }       
        }

      });
});
