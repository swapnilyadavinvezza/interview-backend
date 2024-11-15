<?php $url = Request::segments(); ?>
<div class="content-header">
  <div class="container-fluid">
	<div class="row">
	  <div class="col-sm-6">
		@if(count($url) > 2)
			<h1>{{  ucwords(str_replace("-"," ",$url[1])) }}</h1>
		@else
			<h1>{{  ucwords(str_replace("-"," ",end($url))) }}<h1>
		@endif
	  </div>
	  <div class="col-sm-6">
		<ol class="breadcrumb float-sm-right">
		  <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
		  <li class="breadcrumb-item active">{{ count($url) > 2 ? $url[1] : end($url) }}</li>
		</ol>
	  </div>
	</div>
  </div><!-- /.container-fluid -->
</div>