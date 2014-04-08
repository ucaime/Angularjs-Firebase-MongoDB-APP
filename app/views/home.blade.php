@extends('layout')

@section('content')
<?php 
if (App::environment('local') == "local") {
    $base_link = "";
} else {
    $base_link = "/source_codes/php/Angular-PHP-CRUD/public"; 
}
?>
<div class="">
    <h2>Home page</h2>


    		<div class="posts">
                <h1 class="content-subhead">Pinned Post - Current time: <% date('F j, Y, g:i A') %> </h1>

                <?php  foreach ($ads as $key => $item) { ?>

                    <section class="post">
                        <header class="post-header">
                            <?php 
                                $avatar = ( isset($item["avatar"]) ? $item["avatar"] : "http://purecss.io/img/common/tilo-avatar.png" ); 


                            ?>
                            <img class="post-avatar" alt="Tilo Mitra's avatar" height="48" width="48" src="<?php echo $avatar; ?>">




                            <h2 class="post-title">   <?php echo '<a href="'.'/item/' . $item['_id']->{'$id'} . '"  > '. $item['title'] .'</a>'; ?></h2>

                            <p class="post-meta">
                                By <a href="#" class="post-author"><?php echo $user_name; ?></a> under 
                                <a class="post-category post-category-design" href="#">CSS</a> 
                                <a class="post-category post-category-pure" href="/?category=<?php echo $item['cat']; ?>"><?php echo $item['cat']; ?></a>
                            </p>
                        </header>

                        <div class="post-description">
                            <p>
                                <?php echo Myhelper::myTruncate(nl2br($item['text']), 150) ; ?> 

                                <?php echo '<a href="'. '/item/' . $item['_id']->{'$id'} . '"> <i class="fa fa-long-arrow-right"></i> </a>' ?>
                            </p>
                        </div>
                    </section>

                 
                <?php } ?>
            </div>
</div>
@stop