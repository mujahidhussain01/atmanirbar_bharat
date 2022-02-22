<?php include "common/header.php"?>
<?php include "common/sidebar.php"?>
<style>
    .media.media-sm .media-object {
    width: 64px;
    height: 64px;
    border: 1px solid grey;
}
table.table-bordered.dataTable th, table.table-bordered.dataTable td {
    border-left-width: 0;
    white-space: nowrap;
}
</style>
<div id="content" class="content">
	<ol class="breadcrumb float-xl-right">
		<li class="breadcrumb-item"><a href="<?=site_url('admin/')?>">Home</a></li>
		<li class="breadcrumb-item"><a href="javascript:;">Extensions</a></li>
		<li class="breadcrumb-item active"><a href="javascript:;"><?=$page_title?></a></li>
	</ol>
	<h1 class="page-header"><?=$page_title?> </h1>
	<div class="row">
		<div class="col-12">
			<div class="panel">
				<div class="panel-body  table-responsive">
						<table id="data-table-buttons"  class="table table-centered table-bordered table-condensed table-nowrap">
							<thead>
								<tr>
									<th>S.no</th>
									<th>Loan Id</th>
									<th>Username</th>
									<th>Mobile</th>
									<th>Loan Amount</th>
									<th>Extention days</th>
									<th>Extention amount</th>
									<?php if($sub_page != 'approved_extensions'&&$sub_page != 'rejected_extensions'): ?>
									<th>Action</th>
									<?php endif; ?>
								</tr>
							</thead>
							<?php $sno=0;?>
							<tbody>
							<?php $i=1; foreach($extensions as $la){ ?>
								<tr>
									<td><?=$i?></td>
									<td><?=@$la['la_id']?></td>
									<td><?=@$la['first_name'].' '.$la['last_name']?></td>
									<td><?=@$la['mobile']?></td>
									<td><?=(@$la['amount']?'₹'.@$la['amount']:'NA')?></td>
									<td><?=(@$la['ext_days']?@$la['ext_days'].' days':'NA')?></td>
									<td><?=(@$la['ext_charges']?'₹'.@$la['ext_charges']:'NA')?></td>
									<?php if($sub_page != 'approved_extensions'&&$sub_page != 'rejected_extensions'): ?>
									<td>
									    <select onchange='UpdateDocumentStatus(this)' data-le_id='<?=$la['le_id']?>'>
									        <option value=''>Change Status</option>
									        <?php if($sub_page == 'new_extensions'): ?>
									        <option value='APPROVED'>Approved</option>
									        <option value='REJECTED'>Rejected</option>
									        <?php endif; ?>
									    </select>
									</td>
									<?php endif; ?>
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
			dom: '<"dataTables_wrapper dt-bootstrap"<"row"<"col-xl-7 d-block d-sm-flex d-xl-block justify-content-center"<"d-block d-lg-inline-flex mr-0 mr-sm-3"l><"d-block d-lg-inline-flex"B>><"col-xl-5 d-flex d-xl-block justify-content-center"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>>',
            
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
		function UpdateDocumentStatus(select){ 
		    var value = $(select).val();
		    var le_id = $(select).data('le_id');
		    if(confirm('Are You Sure to change the status')){
            var message = '';
            if(value=="REJECTED"){
                message = prompt('Enter The Reason of rejection');
            }
            var data={value:value,le_id:le_id,message:message};
            $.ajax({
                url:'<?=site_url('admin/extensions/UpdateloanStatus')?>',
                type: "POST",
                data:data,
                success:function(data){
                    location.reload();
                }
            });
		    }
            
        }
</script>