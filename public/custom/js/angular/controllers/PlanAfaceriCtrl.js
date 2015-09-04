function PlanAfaceriCtrl($scope, $http){
	console.log('PlanAfaceriCtrl.js');
	$scope.elements = [];
  	$scope.available_add = true;
  	$scope.available_add_child = true;
  	$scope.available_ux = false; 
  	$scope.selected_item = null; 
  	$scope.plan = null;


  	$scope.list1 = {title: 'AngularJS - Drag Me'};
	$scope.list2 = {};


	$scope.upload = function(){
		$.get($scope.config.r_get_items, function(data){
			console.log(data.items);
			$scope.elements = data.items;
			// $scope.$apply(); 
			 
		}); 
	}
	$scope.settings = function(){
		console.log('settings');
	}
	$scope.graph = function(){
		console.log('graph');
	}
	$scope.share = function(){
		console.log('share');
	}
	$scope.wrench = function(){
		if($scope.selected_item){
					$scope.available_ux = !$scope.available_ux;
					ComponentsEditors.init();
		}
		else{
			alert("Mai întîi selectați un item din capitole.")
		}
	}

	$scope.addItem = function(){
		$scope.available_add = false;

	}
	$scope.addItemChild = function(){
		$scope.available_add_child = false;

	}

	$scope.saveItem = function(){
		$scope.available_add = true; 
		$.post($scope.config.r_save_item,
		{ 
			name : $scope.name_item 
		}, 
		function(data){
			console.log('elements');
			data.child['childrens'] = [];
			$scope.elements.push(data.child);
			console.log($scope.elements);
		}); 
		$scope.name_item = '';
	}

	$scope.saveChildItem = function(item){
		parent_id = item.id;
		console.log(item);
		$scope.available_add_child = true; 
		$.post($scope.config.r_save_item,
		{ 
			parent_id : parent_id,
			name 	  : this.name_item_child
		},function(data){
			console.log(data);
			if('childrens' in item){
				item.childrens.push(data.child);
			}else{
				item['childrens'] = [];
				item.childrens.push(data.child);
			}
		});  
		console.log(item.childrens);
		this.name_item_child = '';
	}

	$scope.removeItem = function(item,array,index){
		item_id = item.id;
		$.post($scope.config.r_remove_item, {item_id: item_id }, function(data){
			if(data != null)
				array.splice(index, 1);
		});
	}

	$scope.updateItem = function(element){
		console.log(element);
		$.post($scope.config.r_update_item, {element: element }, function(data){
			// $scope.elements = data.items;
		});
	}

	$scope.elements = []; 

	$scope.$watch('r_get_items',function(){
		$.get($scope.config.r_get_items, function(data){
			console.log(data.plan);
			$scope.plan = data.plan;
			$scope.elements = data.items;
			// $scope.$apply(); 
		});
	});

  $scope.$watch('$scope.elements', function(newVal, oldVal) {
  	console.log(newVal);
    if (newVal !== oldVal) {
     
    }
  }); 

 	$scope.getArticles = function(element){
 		$scope.selected_item = element;  
	 	$.post($scope.config.r_get_articles, { item_id: element.id }, function(data){
	 		console.log(data);
	 		$('[content=posts]').html(data.html);
	 	});
	 }


	$scope.saveArticles = function($event){
		var _form  = $('.posts-form');
		var inputs = _form.find('[name=content]');
 		console.log(inputs); 

		console.log(inputs);
		console.log(this);
 	}

 	$scope.updatePlan = function(plan){
 		console.log(plan);
 		$.post($scope.config.r_update_item, {plan: plan }, function(data){
			 
		});
 	}





 



}

app.run(function($rootScope){
	$rootScope.config = _config;
});

app.run(function(editableOptions) {
  editableOptions.theme = 'bs3'; // bootstrap3 theme. Can be also 'bs2', 'default'
});


app.controller('PlanAfaceriCtrl', PlanAfaceriCtrl);
