<div class="row">
	<div class="col-md-12">
		<div class="portlet box blue" id="form_wizard_1">
			<div class="portlet-title">
				<div class="caption">
					<span class="step-title"> Pasul 1 din 4 </span>:
					{!! $caption !!}
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
								@foreach($steps['tabs'] as $key => $tab)
									<li>
										<a href="#tab{!!$tab['view']!!}" data-toggle="tab" class="step">
										<span class="number">
										{!! $tab['view'] !!} 
										</span>
										<span class="desc">
										<i class="fa fa-check"></i>{!! $tab['caption'] !!} </span>
										</a>
									</li>
								@endforeach
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

								@foreach($steps['tabs'] as $key => $tab)
									@include('identificarea_nevoii.tab-'.$tab["view"], ['help' => $tab['help']])
								@endforeach
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