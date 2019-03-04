<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('post_message'); ?>
<div class="row mb-3">
  <div class="col">
    <h1>Posts</h1>
  </div>
  <div class="col">
    <a href="<?php echo URLROOT; ?>/posts/add" class="btn btn-primary pull-right"><i class="fa fa-pencil"></i> Add Post</a>
  </div>
</div>

<!-- no posts? -->
<?php if(count($data['posts']) == 0):?>
    <br><br><br>
   <p id="no-posts" class="lead text-center">There are currently no posts. Be the first to add one!</p>
<?php endif; ?>

<?php foreach($data['posts'] as $post): ?>
  <div class="card card-body mb-3 pb-0">
    <h4 class="card-title p-2"><?php echo $post->title; ?></h4>
    <div class="p-2 mb-2">
      <?php if(strlen($post->body) > 400) { //shorten at 400 chars
              echo substr($post->body,0,400) . 
              ' . . . 
              <a style="white-space:nowrap;" class="text-info" href="'.URLROOT.'/posts/show/'.$post->postId.'">(see more)</a>';
            } else {
                echo $post->body;
              } ?>  
    </div>
    <div class="row see-more bg-light p-2 mb-3">
      <div class="col">by <?php echo $post->name. ' on '.$post->created_at;?></div>
      <div class="col text-right">
        <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $post->postId; ?>" class="btn btn-sm btn-info" style="width:30%; min-width:50px;">
          <i class="fa fa fa-long-arrow-right "></i>    
        </a>
      </div>
    </div>
</div>

<?php endforeach; ?>


<?php require APPROOT . '/views/inc/footer.php'; ?>