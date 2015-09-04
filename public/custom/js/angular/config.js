var app = angular.module('app', ['ngRoute']) 
	.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('{[');
    $interpolateProvider.endSymbol(']}');
}) 
.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/', {
        templateUrl: 'partials/index.html',
        controller: 'IndexCtrl'
      }).
      when('/slider', {
        templateUrl: 'partials/slider.html',
        controller: 'TestCtrl'
      }).
      otherwise({
        redirectTo: '/'
      });
  }]);
;
	