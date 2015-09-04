;
var HomePage = function()
{
	this.select2Class = '.select_me';

	var select2 = function(){
		console.log('Init select2');
		// $(this.select2Class).select2();
	}



	return {
		select2 : function(){
			select2();
		},
		init : function(){
			this.select2();
		}
	}
}();