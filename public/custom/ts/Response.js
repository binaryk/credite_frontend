/// <reference path="Validation.ts" />
/// <reference path="binaryk/helpers/Ajax.ts" />
var Response = (function () {
    function Response(endpoint) {
        var _this = this;
        this.endpoint = endpoint;
        this.init = function () {
            var validate = new App.Forms.Validate(), _that = _this;
            validate.addRule("price", {
                rule: 'require',
                message: 'The "Price" field is required'
            });
            validate.addField("message");
            $('#response').on('click', function (e) {
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
                    $('.page-content').prepend(result);
                }
            });
        };
    }
    return Response;
})();
//# sourceMappingURL=Response.js.map