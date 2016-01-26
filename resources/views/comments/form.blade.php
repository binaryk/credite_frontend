<form action="{!! route('comment.submit') !!}" class="form form-orizontal" method="POST">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-lg-2 control-label" for="name">Name</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" id="name" name="name">
                </div>
            </div>
        </div>
    </div>
    <hr>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-lg-2 control-label" for="email">Email</label>
                <div class="col-lg-8">
                    <input type="email" class="form-control" id="email" name="email">
                </div>
            </div>
        </div>
    </div>
    <hr>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-lg-2 control-label" for="title">Title</label>
                <div class="col-lg-8">
                    <input type="text" class="form-control" id="title" name="title">
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
        <button type="button" id="add_message" class="btn btn-primary pull-right"><i class="icon-ok"></i> Send</button>
    </div>
</form>