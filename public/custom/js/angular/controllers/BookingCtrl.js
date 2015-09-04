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
		var type = $scope.point_type = p;
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

	


}



app.run(function($rootScope){
	$rootScope.config = _config;
});
app.controller('BookingCtrl', BookingCtrl);

app.filter('propsFilter', function() {
  return function(items, props) {
    var out = [];

    if (angular.isArray(items)) {
      var keys = Object.keys(props);
        
      items.forEach(function(item) {
        var itemMatches = false;

        for (var i = 0; i < keys.length; i++) {
          var prop = keys[i];
          var text = props[prop].toLowerCase();
          if (item[prop].toString().toLowerCase().indexOf(text) !== -1) {
            itemMatches = true;
            break;
          }
        }

        if (itemMatches) {
          out.push(item);
        }
      });
    } else {
      // Let the output be the input untouched
      out = items;
    }

    return out;
  };
});