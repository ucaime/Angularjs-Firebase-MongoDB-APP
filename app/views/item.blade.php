@extends('layout')

@section('content')

<div class="">
    <h2>Item page</h2>


    		<div class="posts">
                <h1 class="content-subhead">Pinned Post - Current time: <% date('F j, Y, g:i A') %></h1>


                <!-- A single blog post -->
                <section class="post" id="post" data-item-id="<?php echo $ad['_id']->{'$id'}; ?>">
                    <header class="post-header" >
                        <?php 
                            $avatar = ( isset($ad["avatar"]) ? $ad["avatar"] : "http://purecss.io/img/common/tilo-avatar.png" ); 
                            
                        ?>
                        <img class="post-avatar" alt="Tilo Mitra's avatar" height="48" width="48" src="<?php echo $avatar; ?>">

                        <h2 class="post-title"><?php echo $ad['title']; ?> </h2>

                        <p class="post-meta">
                            By <a href="#" class="post-author"><?php echo $user_name; ?> </a> under 
                            <a class="post-category post-category-design" href="#">CSS</a> 
                            <a class="post-category post-category-pure" href="#">Pure</a>
                        </p>
                    </header>

                    <div class="post-description">
                        <p>
                            <?php echo nl2br($ad['text']); ?> 
                        </p>
                    </div>
                </section>

            </div>

            <div class="comments" style="" ng-controller="CommentsBoxCTRL">
                <h1 class="content-subhead">Comments</h1>

               
                <?php if ( Auth::check() ) { ?> 
                <form ng-submit="submitComment()"  class="pure-form pure-form-stacked" method="post" >
                    <fieldset>
                        <textarea ng-model="comment" ng-change="keydown()" name="commnet" placeholder="Enter your comment" id="comment" class="pure-input-1" style="resize:vertical;margin-bottom:10px;"></textarea>
                        <input type="hidden" name="id" value="dsfsdfsdf">
                        <div>
                            <button type="submit" class="button-small pure-button pure-button-primary">Submit</button> 
                            <i style="color: #5aba59;" ng-class="{hide: showCheckMark }" class="fa fa-check"></i>
                        </div>
                    </fieldset>
                </form>
                <?php } else { ?>
                    <p>You need to login to comment!</p>
                <?php } ?>
                <div ng-show="hideSpinner" style="margin-bottom: 40px;">
                    <div class="loading">
                        <div class="loading-dot"></div>
                        <div class="loading-dot"></div>
                        <div class="loading-dot"></div>
                        <div class="loading-dot"></div>
                    </div>
                </div>
                
                <div ng-show="newComment" class="popup">
                  <div class="wrapper">
                       <a href="" ng-click="goToComment()">{{numOfNewComments}} new comment<span ng-show="numOfNewComments>1">s</span></a>
                    </div>
                </div>
                <div class="bubble-list" ng-cloak>
                    <div ng-repeat="bubble in comments" class="bubble clearfix" is-visible>
                        <img ng-src="{{bubble.avatar}}">
                        <div class="bubble-content">
                            <p style="font-size: 10px;color: #6E6E6E;"><a href="">{{bubble.user || 'User'}}</a> replied on {{bubble.timestamp | date:'EEE, y/M/dd - h:mma'}}</p>
                            <div class="point"></div>
                            <pre style="font-family: Verdana, Helvetica, Arial;">{{bubble.comment}}</pre>
                        </div>
                    </div>
                </div>
            </div>
            
</div>

@stop