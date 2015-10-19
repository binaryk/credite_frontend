;app.controller('BookingCtrl',['$scope','$http','$rootScope','$compile','$timeout', function BookingCtrl($scope, $http, $rootScope, $compile, $timeout){
	console.log('BookingCtrl.js'); 

    $scope.submitForm = function(){
    	console.log($('[type=checkbox]'));
    	var checkboxes = $('[type=checkbox]');
    	checkboxes.each(function(index, el) {
    		$scope.form[$(el).attr('data-control-source')] = $(el).is(':checked') ? 1 : 0;
    	});

    	$.post($rootScope.config.post_form, {data: $scope.form}, function(data){
    		console.log(data);
    	});
    	console.log($scope.form);
    }
}]);