;
function BookingForm(parameters){
	this.classActionGetForm = ".action-get-form"
	this.form_data = {};
	this.classCombobox = ".form-select";
	this.type = parameters.type; 
	var self = this;

	this.showform = function(){
		$.ajax({
			url: _config.r_get_form,
			type: 'POST',
			data: {data: self.form_data},
		})
		.done(function(data) {
			console.log("success" + data);
		})
		.fail(function(data) {
			console.log("error" + data);
		});
		
	}



	this.init_handle = function(){
		$(document).on('click',$(this.classActionGetForm), function(){
			self.showform();
		});
	}

	this.init_combobox = function(){
		$(document).on('change','select[name=' + self.type + 'option]',function(){
			var val = $(this).val();

			console.log(self.type +"point");
			$("div[class*="+ self.type +"point]").hide();
			$('.'+self.type+'point'+val).show(); 
			console.log(val);
		});
	}

	this.init_controls = function(){
		var href_     = location.href;
		console.log(href_);
		var switched = href_.split('/')[href_.split('/').length - 1]; 
        document.switched = switched;
		$('.from-nr, .to-nr').hide();
		if(document.switched == '1' /*adica s-a schimbat ordinea locatiilor*/){
			$('.to-nr').show();
		}else{/*adica nu s-a schimbat directia*/
			$('.from-nr').show();
			$('.pay-card').show();
		}
        $('.booking').closest('.to-nr').show();
	}

	this.init = function(){
		// this.init_handle();
		// this.init_combobox();
		this.init_controls();//sa ascunda nr daca nu e din norwitch
	}

	


}