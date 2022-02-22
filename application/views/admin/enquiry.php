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
		<li class="breadcrumb-item"><a href="javascript:;">User loans</a></li>
		<li class="breadcrumb-item active"><a href="javascript:;"><?=$page_title?></a></li>
	</ol>
	<h1 class="page-header"><?=$page_title?> </h1>
	<div class="row">
		<div class="col-12">
			<div class="panel">
				<div class="panel-body">
						<table id="data-table-buttons"  class="table table-centered table-bordered table-condensed table-nowrap">
							<thead>
								<tr>
									<th>S.no</th>
									<th>Username</th>
									<th>Email</th>
									<th>Mobile</th>
									<th>Title</th>
									<th>Message</th>
									<th>Date of Creation</th>
								</tr>
							</thead>
							<?php $sno=0;?>
							<tbody>
							<?php $i=1; foreach($enquiry as $e){
							    if($e['user_id'] != NULL){
							        $user = $this->User_model->GetUserById($e['user_id']);
							    }
							?>
								<tr>
									<td><?=$i?></td>
									<td><?=($e['user_id'] != NULL?@$user->first_name.' '.@$user->last_name:$e['name'])?></td>
									<td><?=($e['user_id'] != NULL?@$user->email:$e['email'])?></td>
									<td><?=($e['user_id'] != NULL?@$user->mobile:$e['phone'])?></td>
									<td><?=@$e['title']?></td>
									<td><?=@$e['message']?></td>
									<td><?=@$e['f_doc']?></td>
								</tr>
							<?php $i++;} ?>
							</tbody>
						</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include "common/footer.php"?>
<script type="text/javascript">
	$('#data-table-buttons').DataTable({
			dom: '<"row"<"col-sm-5"B><"col-sm-7"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>',
			buttons: [ {
				extend: 'excel',
				className: 'btn-sm'
			}, {
				extend: 'pdf',
				className: 'btn-sm'
			}, {
				extend: 'print',
				className: 'btn-sm'
			},{
            extend: 'colvis',
			className: 'btn-sm'
        }],
			responsive: false
		});
</script>