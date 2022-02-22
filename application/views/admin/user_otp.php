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
		<li class="breadcrumb-item active"><a href="javascript:;">User Otp</a></li>
	</ol>
	<h1 class="page-header">User Otp </h1>
	<div class="row">
		<div class="col-12">
			<div class="panel panel-inverse">
				<div class="panel-heading">
					<h4 class="panel-title">User Otp</h4>
				</div>
				<div class="panel-body">
						<table id="data-table-buttons"  class="table table-centered table-bordered table-condensed table-nowrap">
							<thead>
								<tr>
									<th>S.no</th>
									<th>Mobile</th>
									<th>otp</th>
									<th>Date Of Creation</th>
									<th>Date Of Modification</th>
									<th>Otp Status</th>
								</tr>
							</thead>
							<?php $sno=0;?>
							<tbody>
							<?php $i=1; foreach($otps as $otp){?>
								<tr>
									<td><?=$i?></td>
									<td><?=$otp['mobile_number']?></td>
									<td><?=$otp['otp']?></td>
									<td><?=$otp['created_date']?></td>
									<td><?=$otp['past_modified_date']?></td>
									<td><?=$otp['status']?></td>
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