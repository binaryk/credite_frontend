<div class="portlet box green ">
    <div class="portlet-title">
        <div class="caption"> Date personale
        </div>
        <div class="tools">
            <a href="" class="collapse" data-original-title="" title="">
            </a>
        </div>
    </div>
    <div class="portlet-body form">
        @if(isset($message))
            adsada
        @endif
        <form action="{!! route('client.profile.store') !!}" role="FORM" class="horizontal-form general_form" method="POST" id="profile">
        <div class="form-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                {!! $fields['lname'] !!}
                            </div>
                            <div class="col-md-6">
                                {!! $fields['fname'] !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="col-md-6">
                                {!! $fields['email'] !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="note note-info">
                        <h4 class="block">Confidentialitate!</h4>
                        <p>
                            Aceste date au caracter personal, nu vor fi utilizate in scopuri comerciale sau publice.
                        </p>
                    </div>
                </div>
            </div>
        </div>
            <div class="form-actions fluid">
                <div class="col-md-9">
                    <button type="submit" class="btn green">Salveaza</button>
                </div>
            </div>
        </form>
    </div>
</div>