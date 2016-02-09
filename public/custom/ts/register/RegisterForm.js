/// <reference path="../Validation.ts" />
var RegisterForm = (function () {
    function RegisterForm() {
        var _this = this;
        this.init = function () {
            var validate = new App.Forms.Validate(), _that = _this;
            validate.addRule("name", {
                rule: 'require',
                message: 'Nu uitati sa completati campul "Nume"'
            });
            validate.addRules("email", [
                {
                    rule: 'require',
                    message: 'Nu uitati sa completati campul de "Email"'
                },
                {
                    rule: 'email',
                    message: 'Campul "Email" nu este valid'
                }
            ]);
            validate.addRule("password", {
                rule: 'require',
                message: 'Nu uitati sa completati campul "Parola"'
            });
            $('#register').on('submit', function (e) {
                if (validate.validate()) {
                    console.log('Valid form');
                }
                else {
                    e.preventDefault();
                }
            });
            return validate;
        };
    }
    return RegisterForm;
})();
(new RegisterForm()).init();
//# sourceMappingURL=RegisterForm.js.map