<?php include "common/header.php"?>
<?php include "common/sidebar.php"?>
<style>
    .media.media-sm .media-object {
    width: 64px;
    height: 64px;
    border: 1px solid grey;
}
</style>
<div id="content" class="content">
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item"><a href="<?=site_url('admin/')?>">Home</a></li>
		<li class="breadcrumb-item"><a href="javascript:;">User Notification</a></li>
	</ol>
	<h1 class="page-header">User Notifications</h1>
	<div class="row">
		<div class="col-12">
			<div class="card">
                <ul class="list-group list-group-flush">
			    <?php foreach($notifications as $notify){?>
                    <a href='<?=base_url().$notify['redirect_link']?>' class="list-group-item list-group-item-action d-flex align-items-center text-ellipsis bg-transparent">
                        <i class="fa fa-circle fa-fw text-warning mr-2 f-s-8"></i>
                        <div>
                            <?=$notify['notify_content']?>
                            <div class="text-muted f-s-12"><?=calculatetime($notify['notify_doc'])?></div>
                        </div>
                    </a>
			    <?php }?>
                </ul>
            </div>
		</div>
	</div>
</div>
<?php include "common/footer.php"?>