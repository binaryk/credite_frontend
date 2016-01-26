/// <reference path="Validation.ts" />
/// <reference path="binaryk/helpers/Ajax.ts" />
class Response{
    constructor(public endpoint: Object){
    }

    init = ():App.Forms.Validate => {
        var validate = new App.Forms.Validate(),
            _that    = this;
        validate.addRule(
            "price",
            {
                rule: 'require',
                message: 'The "Price" field is required'
            }
        )
        validate.addField("message")

        $('#response').on('click', function(e){
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

                $('.page-content').prepend(result);
            }
        });
    }
}

