/// <reference path="Validation.ts" />
/// <reference path="binaryk/helpers/Ajax.ts" />
class Reviews{
    constructor(public endpoint: Object){
    }

    init = ():App.Forms.Validate => {
        var validate = new App.Forms.Validate(),
            _that    = this;
        validate.addRule(
            "name",
            {
                rule: 'require',
                message: 'Câmpul "Nume" este obligatoriu (va aparea la comentariu)'
            }
        )
        validate.addRule(
            "title",
            {
                rule: 'require',
                message: 'Câmpul "Titlu" este obligatoriu'
            }
        )
        validate.addRules(
            "email",
            [
                {
                    rule: 'require',
                    message: 'Câmpul "Email" este obligatoriu'
                },
                {
                    rule: 'email',
                    message: 'Câmpul "Email" nu pare să fie valid'
                }
            ]
        )
        validate.addRule(
            "message",
            {
                rule: 'require',
                message: 'Câmpul "Mesaj" este obligatoriu (spune-ne ce gandești despre noi)'
            }
        )

        $('#add_message').on('click', function(e){
            if( validate.validate() ){
                console.log('Valid form');
                _that._ajax(validate);
            }
        })
        return validate;
    }

    _ajax = (validate) => {
        $.ajax({
            url      : this.endpoint['endPoit'],
            type     : 'POST',
            data     : validate.getJsonData(),
            success  : function( result )
            {
                validate.clearFields();
                console.log(result);
                
                $('.content-page').prepend(result);
            }
        });
    }
}

