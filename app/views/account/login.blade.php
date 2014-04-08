@extends('layout')

@section('content')
<h1>Login</h1>
<!-- check for login error flash var -->
    @if (Session::has('flash_error'))
        <div  class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> <% Session::get('flash_error') %></div>
    @endif

<% Form::open(array('url' => 'login', 'method' => 'post', 'class' => "pure-form pure-form-aligned" )) %>
	<fieldset>
        <div class="pure-control-group">
		 	<?php echo Form::label('email', 'E-Mail Address');  ?>
		 	<?php echo Form::text('email'); ?>
 		</div>
		<div class="pure-control-group">
		 	<?php echo Form::label('password', 'Password'); ?>
		 	<?php echo Form::password('password'); ?>
		</div>
		<div class="pure-controls">
			<button type="submit" class="pure-button pure-button-primary">Login</button>
		</div>
	</fieldset>

<% Form::close() %>

@stop

