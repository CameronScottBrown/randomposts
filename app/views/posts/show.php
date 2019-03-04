<?php require APPROOT . '/views/inc/header.php'; ?>

<a href="<?php echo URLROOT; ?>/posts" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> Back</a>
<br>
<div class="container mt-3">
    <h1><?php echo $data['post']->title; ?></h1>
    <div class="bg-light p-2 mb-3 rounded">
        by <?php echo $data['user']->name; ?> on 
        <?php echo $data['post']->created_at;?>
    </div>
    <p class="p-2"><?php echo $data['post']->body; ?></p>


    <!-- check if post belongs to logged in user -->
    <?php if($data['post']->user_id == $_SESSION['user_id']) : ?>
    <hr>
    <div class="row">
        <div class="col">
            <a href="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['post']->id;?>"            class="btn btn-secondary text-white" ><i class="fa fa-pencil"></i> Edit</a>
        </div>
        <div class="col">
            <form class="float-right" action="<?php echo URLROOT; ?>/posts/delete/<?php echo $data['post']->id; ?>" method="post">
                <button type="Submit" class="btn btn-danger"><i class="fa fa-trash-o"></i> Delete</button>
            </form>
        </div>
    </div>
    <?php endif; ?>



</div>


<?php require APPROOT . '/views/inc/footer.php'; ?>