<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?php echo URLROOT; ?>/posts/<?php echo $data['post']->id; ?>" class="btn btn-warning"><i class="fa fa-long-arrow-left"></i> Back</a>
<div class="card card-body bg-light mt-5">
    <h2>Edit Post</h2>
    <p>Make changes to your post below.</p>
    <form action="<?php echo URLROOT . '/posts/edit/' . $data['id'];?>" method="post">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" name="title" class="form-control form-control-lg <?php 
            echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
            <span class="invalid-feedback"><?php echo $data['title_err'] ?></span>
        </div>
        <div class="form-group">
            <label for="body">Body:</label>
            <textarea name="body" class="form-control form-control-lg <?php echo (!empty($data['body_err'])) ? 'is-invalid' : ''; ?>"><?php echo $data['body']; ?></textarea>
            <span class="invalid-feedback"><?php echo $data['body_err']; ?></span>
        </div>
        <span class="float-right"><input type="submit" class="btn btn-success" value="Submit"></span>
    </form>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>