var Reset = function() {
 

    var handleReset = function() {  

        $('#reset-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {

                email: {
                    required: true,
                    email: true
                },  
                password: {
                    required: true
                },
                password_confirmation: {
                    equalTo: "#forgot_password"
                } 
            },

            messages: {
                email: {
                    required: "Email-ul este obligatoriu.",
                    email: "Email-ul nu este valid"
                },
                password: {
                    required: "Introduceti parola."
                },
                password_confirmation:{
                    equalTo: "Parolele nu coincid"
                } 
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   

            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function(error, element) {
                if (element.attr("name") == "tnc") { // insert checkbox errors after the container                  
                    error.insertAfter($('#register_tnc_error'));
                } else if (element.closest('.input-icon').size() === 1) {
                    error.insertAfter(element.closest('.input-icon'));
                } else {
                    error.insertAfter(element);
                }
            },

            submitHandler: function(form) {
                form.submit();
            }
        }); 
    }

    return {
        //main function to initiate the module
        init: function() {

            handleReset();

        }

    };

}();