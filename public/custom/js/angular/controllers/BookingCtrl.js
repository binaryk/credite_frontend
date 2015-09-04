;
function BookingCtrl($scope, $http){
	console.log('BookingCtrl.js');
	$scope.airports = [];
	$scope.point_types = [
		{ name: 'Adress', id: '1' },
		{ name: 'Airport', id: '2' },
		{ name: 'Postal code', id: '3' },
		{ name: 'Choose your pickup address', id: '4' }
	];
	$scope.point_type = $scope.point_types[0];
		
	$scope.$watch('point_types',function(){
		$('.select_me').select2();
	});

	$scope.$watch('r_get_airports',function(){
		console.log($scope.config.r_get_airports);
		$.get($scope.config.r_get_airports, function(data){
			console.log(data);
			$scope.airports = data.airports;
		});
	});

	


}



app.run(function($rootScope){
	$rootScope.config = _config;
});
app.controller('BookingCtrl', BookingCtrl);