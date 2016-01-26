/// <reference path="Validation.ts" />
/// <reference path="binaryk/helpers/Ajax.ts" />
var Reviews = (function () {
    function Reviews(endpoint) {
        var _this = this;
        this.endpoint = endpoint;
        this.init = function () {
            var validate = new App.Forms.Validate(), _that = _this;
            validate.addRule("name", {
                rule: 'require',
                message: 'The "Name" field is required'
            });
            validate.addRule("title", {
                rule: 'require',
                message: 'The "Title" field is required'
            });
            validate.addRules("email", [
                {
                    rule: 'require',
                    message: 'The "Email" field is required'
                },
                {
                    rule: 'email',
                    message: 'The "Email" field is not valid'
                }
            ]);
            validate.addRule("message", {
                rule: 'require',
                message: 'The "Message" field is required'
            });
            $('#add_message').on('click', function (e) {
                if (validate.validate()) {
                    console.log('Valid form');
                    _that._ajax(validate);
                }
            });
            return validate;
        };
        this._ajax = function (validate) {
            $.ajax({
                url: _this.endpoint['endPoit'],
                type: 'POST',
                data: validate.getJsonData(),
                success: function (result) {
                    validate.clearFields();
                    console.log(result);
                    $('.content-page').prepend(result);
                }
            });
        };
    }
    return Reviews;
})();
//# sourceMappingURL=Reviews.js.map