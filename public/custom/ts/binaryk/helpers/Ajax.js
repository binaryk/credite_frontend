/*module App.Forms{
  export class AjaxHelper{
    url : string = null;
    type: string = 'POST';
    dataType: string = 'json';
    _token : string  = null;
    data   : Object  = {};

    constructor(){

    }


  }
}*/
var App;
(function (App) {
    var Forms;
    (function (Forms) {
        var Ajax = (function () {
            function Ajax(url, data, context, method) {
                var _this = this;
                this.url = url;
                this.data = data;
                this.context = context;
                this.method = method;
                this.dataType = 'json';
                this.call = function () {
                    var that = _this;
                    $.ajax({
                        url: that.url,
                        type: that.method,
                        dataType: that.dataType,
                        data: that.data,
                        success: function (result) {
                            console.log(result);
                            return that.onFinish(result);
                        }
                    });
                };
                this.onFinish = function (data) {
                    if (data.code === 200) {
                        _this.showSuccess(data.message);
                    }
                };
                this.showSuccess = function (message) {
                    var inject = "<div class=\"alert alert-success alert-dismissible fade in callback\" role=\"alert\">\n          <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button>\n          <strong> " + message + "\n          <br>\n          </div>";
                    $(_this.context).find('.alert.callback').remove();
                    $(_this.context).prepend(inject);
                };
                this.setData = function (data) {
                    _this.data = data;
                };
                this.getData = function () {
                    return _this.data;
                };
                this.setUrl = function (url) {
                    _this.url = url;
                };
                this.getUrl = function () {
                    return _this.url;
                };
                this.setMethod = function (method) {
                    _this.method = method;
                };
                this.getMethod = function () {
                    return _this.method;
                };
                if (!method) {
                    this.method = 'post';
                }
                this.context = this.context === undefined ? this.context : 'form.general_form';
            }
            return Ajax;
        })();
        Forms.Ajax = Ajax;
    })(Forms = App.Forms || (App.Forms = {}));
})(App || (App = {}));
;
var ComptechHelperAjax = function (options) {
    this.url = null;
    this.type = 'post';
    this.dataType = 'json';
    this._token = null;
    this.data = {};
    $.extend(this, options);
    this.data._token = this._token;
    this.onFinish = function (result) {
    };
    this.setUrl = function (url) {
        this.url = url;
        return this;
    };
    this.setData = function (key, value) {
        this.data[key] = value;
        return this;
    };
    this.setOnFinish = function (callback) {
        this.onFinish = callback;
        return this;
    };
    this.Request = function () {
        var that = this;
        $.ajax({
            url: this.url,
            type: this.type,
            dataType: this.dataType,
            data: this.data,
            success: function (result) {
                return that.onFinish(result);
            }
        });
    };
};
//# sourceMappingURL=Ajax.js.map