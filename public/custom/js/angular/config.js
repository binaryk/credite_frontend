var app = angular.module('app', []) 
	.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('{[');
    $interpolateProvider.endSymbol(']}');
}) 
;
/*
.config(function($stateProvider, $urlRouterProvider) {
  // For any unmatched url, redirect to /state1
  $urlRouterProvider.otherwise("/state1");
  // Now set up the states
  $stateProvider
    .state('state1', {
      url: "/",
      templateUrl: "partials/index.html",
      controller: IndexCtrl
    })
    .state('state2', {
      url: "/slider",
      templateUrl: "partials/slider.html",
      controller: IndexCtrl
      
    })
    .state('state3', {
      url: "/test",
      templateUrl: "partials/test",
      controller: IndexCtrl
      
    })
    .state('booking-form', {
      url: "/slider",
      templateUrl: "partials/slider.html",
      controller: IndexCtrl
      
    });
});*/