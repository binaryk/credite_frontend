/// <reference path="Validation.ts" />
/// <reference path="binaryk/helpers/Ajax.ts" />
class Request{
    constructor(){
    }

    init = ():App.Forms.Validate => {
        var validate = new App.Forms.Validate(),
            _that    = this;
        validate.addRule(
            "from",
            {
                rule: 'require',
                message: 'The "From" field is required'
            }
        )
        validate.addRule(
            "to",
            {
                rule: 'require',
                message: 'The "To" field is required'
            }
        )
        $('#quick_submit').on('click', function(e){
            if( validate.validate() ){
                console.log('Valid form');
                $('#request_form').submit();
            }
        })
        return validate;
    }
}

