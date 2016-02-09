/// <reference path="../Validation.ts" />
class ClientProfileForm{
    constructor(){
    }

    init = ():App.Forms.Validate => {
        var validate = new App.Forms.Validate(true),
            _that    = this;
        validate.addRule(
            "fname",
            {
                rule: 'require',
                message: 'Nu uitati sa completati campul "Prenume"'
            }
        )
        validate.addRule(
            "lname",
            {
                rule: 'require',
                message: 'Nu uitati sa completati campul "Nume"'
            }
        )

        $('#profile').on('submit', function(e){
            if( validate.validate() ){

                if(validate.defaultAjax){
                    e.preventDefault();
                    validate.ajaxSubmit($(this).attr('action'));
                }
                console.log('Valid form');
            }else{
                e.preventDefault();
            }
        })
        validate.validate();
        return validate;
    }
}

(new ClientProfileForm()).init();