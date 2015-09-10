;
function BookingCtrl($scope, $http){
	console.log('BookingCtrl.js');
	$scope.airports = [];
	$scope.airport = {};
	$scope.point_type = '';

	$scope.point_types = [
		{ id: '1', name:'Adress'},
		{ id: '2', name:'Airport'},
		{ id: '3', name:'Postal code'},
		{ id: '4', name:'Choose your pickup address' }]
		
	$scope.$watch('point_types',function(){
		console.log($scope.point_types);
	});

	$scope.$watch('r_get_airports',function(){
		console.log($scope.config.r_get_airports);
		$.get($scope.config.r_get_airports, function(data){
			console.log(data);
			$scope.airports = data.airports;
			// $scope.$apply(); 
		});
	});

	$scope.changePoint = function(p){
		var type = p;
		console.log(type);
		
		switch(type) {
			case 1:

					
				break;
			case 2:
				
				break;
			case 3:
				
				break;
			case 4:
				
				break;
		}
	}

	$scope.selectAirport = function(el, model){
		console.log(el);
		console.log(model);
	}

	$scope.getCommand = function(){
		console.log('Get command');
	}

	$scope.isOdd = function ($value) {
        return $value % 2;
    };

    $scope.submitBooking = function(){
    	console.log('submit');
    }
	


}



app.run(function($rootScope){
	$rootScope.config = _config;
});
app.controller('BookingCtrl', BookingCtrl);