/// <reference path="../Validation.ts" />
class RegisterForm{
    constructor(){
    }

    init = ():App.Forms.Validate => {
        var validate = new App.Forms.Validate(),
            _that    = this;
        validate.addRule(
            "name",
            {
                rule: 'require',
                message: 'Nu uitati sa completati campul "Nume"'
            }
        )
        validate.addRules(
            "email",
           [
               {
                   rule: 'require',
                   message: 'Nu uitati sa completati campul de "Email"'
               },
               {
                   rule: 'email',
                   message: 'Campul "Email" nu este valid'
               }
           ]
        )
        validate.addRule(
            "password",
            {
                rule: 'require',
                message: 'Nu uitati sa completati campul "Parola"'
            }
        )

        $('#register').on('submit', function(e){
            if( validate.validate() ){
                console.log('Valid form');
            }else{
                e.preventDefault();
            }
        })
        return validate;
    }
}

(new RegisterForm()).init();