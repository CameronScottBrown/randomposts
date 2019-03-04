<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="jumbotron jumbotron-fluid text-center">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <h2 class=""><?php echo $data['title']; ?></h2>
                <p class="lead"><?php echo $data['description']; ?></p>
            </div>
        </div>
    </div>
</div>
	<div class="container-fluid">
		<div class="row login">
			<p>If you're visiting for a demo, please use:</p>
		<div class="credentials">
			<pre>email:	demo@demo.com<br>pw:	demo123</pre>
		</div>
		
		<p>Feel free to post, read, edit, or delete.</p>
	</div>



<?php require APPROOT . '/views/inc/footer.php'; ?>