@extends('layout')

@section('content')
  <h2>Profile </h2><img class="post-avatar" alt="Tilo Mitra's avatar" height="48" width="48" src="<?php echo $avatar; ?>">
  <p> Welcome "<strong>{{ Auth::user()->email }}</strong>" to the protected page!</p>
  <p>Your user ID is: {{ Auth::user()->id }}</p>
  
  	<div ng-controller="ProfileImageCTRL">
   		choose a single file: <input type="file" name="file" ng-file-select="onFileSelect($files)">
	</div>
@stop