@extends('layout')

@section('content')

<h1>Sign-up Form</h1>
<!-- check for login error flash var -->

    @if ( $errors->count() > 0 )
      <div id="flash_error">
      <p>The following errors have occurred:</p>

      <ul>
        @foreach( $errors->all() as $message )
          <li><% $message %></li>
        @endforeach
      </ul>
  	</div>
    @endif

<% Form::open(array('url' => 'register', 'method' => 'post', 'class'=>"pure-form pure-form-aligned" )) %>
    <fieldset>
        <div class="pure-control-group">
         <?php echo Form::label('email', 'Email');  ?>
         <?php echo Form::text('email'); ?>
        </div>

        <div class="pure-control-group">
         <?php echo Form::label('password', 'Password'); ?>
         <?php echo Form::password('password'); ?>
        </div>

        <div class="pure-control-group">
         <?php echo Form::label('password_confirmation', 'Re-enter Password'); ?>
         <?php echo Form::password('password_confirmation'); ?>
         </div>
    <div class="pure-controls">
 
      <button type="submit" class="pure-button pure-button-primary">Register</button>
    </div>
  </fieldset>
<% Form::close() %>

@stop


