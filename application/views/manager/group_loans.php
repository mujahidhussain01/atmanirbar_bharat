<?php include "common/header.php" ?>

<?php include "common/sidebar.php" ?>

<style>

</style>

<div class="app-content content">
<div class="content-wrapper-before" style="position: relative;">
		<div class="content-header row">
			<div class="content-header-left col-md-4 col-12">
				<h5 class="content-header-title text-center mt-1 text-white">Group Loans List</h5>
			</div>
		</div>
	</div>
    <div class="content-wrapper">
        <div id="content" class="content-body">

        <div class="row">
                <form method="get" class="col-12 row pr-0" action="<?php echo base_url('manager/group_loans') ?>">
                    <div class="col-12 d-flex">
                        <input type="text" name="search" class="form-control" id="search" placeholder="Search Loan By Name" value="<?=$search?>">
                        <button type="submit" class="btn btn-primary ml-1"><i class="fa fa-search"></i></button>
                    </div>
                </form>
            </div>

            <hr>



            <?php if (!empty($group_loans)) : ?>

                <div class="panel-group" id="accordion">


                    <?php foreach ($group_loans as $key => $loan) : ?>

                        <div class="card">
                        <a href="<?=base_url()?>manager/group_loans/loan_info/<?=$loan[ 'lsid' ] ?>">
                            <div class="card-header">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h6 class="panel-title text-capitalize">
                                           <?=  ( $key+1 ).'. '.$loan['loan_name']?> ( ₹<?=$loan[ 'amount' ] ?> )
                                           <div class="m-1">
                                           Users Count : <?= $this->Loan_apply_model->get_group_loan_user_count( $loan[ 'lsid' ] )?>
                                           </div>
                                           
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </a>
                        </div>

                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="col"> No Group Loans Found</div>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>
<?php include "common/footer.php" ?>