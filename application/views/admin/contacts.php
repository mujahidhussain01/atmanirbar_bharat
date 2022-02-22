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
		<li class="breadcrumb-item"><a href="javascript:;">App Installs</a></li>
		<li class="breadcrumb-item"><a href="javascript:;">Users</a></li>
		<li class="breadcrumb-item active"><a href="javascript:;">Contacts</a></li>
	</ol>
	<h1 class="page-header"><?=$page_title?> </h1>
	<div class="row">
		<div class="col-12">
			<div class="panel panel-inverse">
				<div class="panel-heading">
					<h4 class="panel-title"><?=$page_title?></h4>
				</div>
				<div class="panel-body ">
						<table id="data-table-buttons"  class="table table-centered table-bordered table-condensed">
							<thead>
								<tr>
									<th>S.no</th>
									<th>Name</th>
									<th>Mobile</th>
								</tr>
							</thead>
							<tbody>
							<?php $i=1; foreach($contacts as $u){?>
								<tr>
									<td><?=$i?></td>
									<td><?=$u['name']?></td>
									<td><?=$u['mobileNumber']?></td>
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
<script>
    
	$('#data-table-buttons').DataTable({
			dom: '<"dataTables_wrapper dt-bootstrap"<"row"<"col-xl-7 d-block d-sm-flex d-xl-block justify-content-center"<"d-block d-lg-inline-flex mr-0 mr-sm-3"l><"d-block d-lg-inline-flex"B>><"col-xl-5 d-flex d-xl-block justify-content-center"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>>',
            
			buttons: [ {
				extend: 'excel',
				className: 'btn-sm'
			}, {
            extend: 'colvis',
			className: 'btn-sm'
        }],
			responsive: false
		});
</script>