<div class="row">
    <div class="col-md-12">
        <div class="istoric" style="display: none;">
            @include('client.fisa.forms.tab_6_istoric')
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="portlet box blue" id="form_wizard_1">
            <div class="portlet-title">
                <div class="caption">
                    <span class="step-title"> Pasul 1 din 4 </span>:
                </div>
                <div class="tools hidden-xs">
                </div>
            </div>
            <div class="portlet-body form">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="" id="submit_form" method="POST">
                    <div class="form-wizard">
                        <div class="form-body">
                            <ul class="nav nav-pills nav-justified steps">
                                    <li>
                                        <a href="#tab1" data-toggle="tab" class="step">
										<span class="number">
										1
										</span>
										<span class="desc">
										<i class="fa fa-check"></i>Generale</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab2" data-toggle="tab" class="step">
										<span class="number">
										2
										</span>
										<span class="desc">
										<i class="fa fa-check"></i>Venituri </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab3" data-toggle="tab" class="step">
										<span class="number">
										3
										</span>
										<span class="desc">
										<i class="fa fa-check"></i>Angajator </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab4" data-toggle="tab" class="step">
										<span class="number">
										4
										</span>
										<span class="desc">
										<i class="fa fa-check"></i>Chestionar </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab7" data-toggle="tab" class="step">
										<span class="number">
										5
										</span>
										<span class="desc">
										<i class="fa fa-check"></i>Garantie </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab8" data-toggle="tab" class="step">
										<span class="number">
										6
										</span>
										<span class="desc">
										<i class="fa fa-check"></i>Confirmare </span>
                                        </a>
                                    </li>
                            </ul>
                            <div id="bar" class="progress progress-striped" role="progressbar">
                                <div class="progress-bar progress-bar-success">
                                </div>
                            </div>
                            <div class="tab-content">
                                <div class="alert alert-danger display-none">
                                    <button class="close" data-dismiss="alert"></button>
                                    Aveti cateva erori, va rugam sa urmariti formularul de mai jos.
                                </div>
                                <div class="alert alert-success display-none">
                                    <button class="close" data-dismiss="alert"></button>
                                    Validarea formularului a fost realizata cu success.
                                </div>
                                @include('client.fisa.forms.tab_1')
                                @include('client.fisa.forms.tab_2')
                                @include('client.fisa.forms.tab_3')
                                @include('client.fisa.forms.tab_4')
                                @include('client.fisa.forms.tab_7_garantie')
                                @include('client.fisa.forms.confirmare')
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <a href="javascript:;" class="btn default button-previous">
                                        <i class="m-icon-swapleft"></i> Inapoi </a>
                                    <a href="javascript:;" class="btn blue button-next">
                                        Mergi mai departe <i class="m-icon-swapright m-icon-white"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>