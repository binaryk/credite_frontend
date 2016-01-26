<form action="{!! route('admin_requests_response_post') !!}" class="form form-orizontal" method="POST">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-lg-2 control-label" for="price">Price</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" id="price" name="price">
                </div>
            </div>
        </div>
    </div>
    <hr>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-lg-2 control-label" for="message">Message</label>
                <div class="col-lg-8">
                    <textarea class="form-control" rows="6" id="message" name="message"></textarea>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="col-md-10" style="margin-top:10px;">
        <div class="clearfix">
        </div>
        <button type="button" id="response" class="btn btn-primary pull-right"><i class="icon-ok"></i> Send</button>
    </div>
</form>