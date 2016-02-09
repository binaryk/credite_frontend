declare var $;
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
module App.Forms{
  export class Ajax{
    dataType : string = 'json';

    constructor(public url,public data, public context, public method){
      if(!method){
        this.method = 'post';
      }
        this.context = this.context === undefined ? this.context : 'form.general_form'

    }

    call = () => {
      var that = this;
      $.ajax({
        url      : that.url,
        type     : that.method,
        dataType : that.dataType,
        data     : that.data,
        success  : function( result )
        {
            console.log(result);
            return that.onFinish(result);
        }
      });
    }

    onFinish = (data) => {
        if(data.code === 200){
            this.showSuccess(data.message);
        }
    }

      showSuccess = (message : string): void => {
         var inject =
             `<div class="alert alert-success alert-dismissible fade in callback" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
          <strong> `+ message +`
          <br>
          </div>`;
          $(this.context).find('.alert.callback').remove();
          $(this.context).prepend(inject);
      }

    setData = (data) => {
      this.data = data;
    }

    getData = () => {
      return this.data;
    }

    setUrl = (url) => {
      this.url = url;
    }

    getUrl = () => {
      return this.url;
    }

    setMethod = (method) => {
      this.method = method;
    }

    getMethod = () => {
      return this.method;
    }


  }
}


; var ComptechHelperAjax = function( options )
{
  this.url      = null;
  this.type     = 'post';
  this.dataType = 'json';
  this._token   = null;
  this.data     = {};

  $.extend( this, options);
  this.data._token = this._token;

  this.onFinish = function(result)
  {
  };

  this.setUrl = function(url)
  {
    this.url = url;
    return this;
  }

  this.setData = function(key, value)
  {
    this.data[key] = value;
    return this;
  }

  this.setOnFinish = function(callback)
  {
    this.onFinish = callback;
    return this;
  }

  this.Request = function()
  {
    var that = this;
    $.ajax({
      url      : this.url,
      type     : this.type,
      dataType : this.dataType,
      data     : this.data,
      success  : function( result )
      {
        return that.onFinish(result);
      }
    });
  }
}