<?php

defined('BASEPATH') or exit('No direct script access allowed');



class User extends CI_Controller
{

	function __construct()

	{

		parent::__construct(); {

			if (!isset($this->session->userdata['user'])) {

				redirect('admin/login');
			}



			$this->load->model('User_model');

			$this->load->model('Loan_apply_model');


			$this->load->model('Loan_payments_model');

			$this->load->model('User_app_contacts_model');
		}
	}



	public function index()
	{

		$this->data['page'] = 'app_installs';

		$this->data['sub_page'] = 'all_users';

		$this->data['page_title'] = 'View All Users';

		$this->data['current_page_name'] = 'All Users';

		$this->data['bda'] = true;

		$this->data['pa'] = true;

		$this->data['docv'] = true;

		$this->data['sa'] = true;

		$this->data['users'] = $this->User_model->GetAllUsers();

		$this->load->view('admin/user', $this->data);
	}



	public function pending()
	{

		$this->data['page'] = 'app_installs';

		$this->data['sub_page'] = 'pending_users';

		$this->data['page_title'] = 'View All Pending Users';

		$this->data['current_page_name'] = 'All Pending Users';

		$this->data['bda'] = true;

		$this->data['pa'] = true;

		$this->data['docv'] = true;

		$this->data['sa'] = true;

		$this->data['users'] = $this->User_model->GetAllPendingUsers();

		$this->load->view('admin/user', $this->data);
	}



	public function document_pending()

	{

		$this->data['page'] = 'app_installs';

		$this->data['sub_page'] = 'document_pending';

		$this->data['page_title'] = 'View All Documents Pending Users';

		$this->data['current_page_name'] = 'Documents Pending Users';

		$this->data['bda'] = true;

		$this->data['pa'] = true;

		$this->data['docv'] = true;

		$this->data['sa'] = true;

		$this->data['users'] = $this->User_model->GetdocumentPendingUsers();

		$this->load->view('admin/user', $this->data);
	}



	public function approved()
	{

		$this->data['page'] = 'app_installs';

		$this->data['sub_page'] = 'approved_users';

		$this->data['page_title'] = 'View All Approved Users';

		$this->data['current_page_name'] = 'All Approved Users';

		$this->data['bda'] = true;

		$this->data['pa'] = true;

		$this->data['docv'] = true;

		$this->data['sa'] = true;

		$this->data['users'] = $this->User_model->GetAllVerifiedUsers();

		$this->load->view('admin/user', $this->data);
	}

	public function rejected()
	{

		$this->data['page'] = 'app_installs';

		$this->data['sub_page'] = 'rejected_users';

		$this->data['page_title'] = 'View All Rejected Users';

		$this->data['current_page_name'] = 'All Rejected Users';

		$this->data['bda'] = true;

		$this->data['pa'] = true;

		$this->data['docv'] = true;

		$this->data['sa'] = true;

		$this->data['users'] = $this->User_model->GetAllRejectedUsers();

		$this->load->view('admin/user', $this->data);
	}


	public function getusersdata()
	{

		$daterange = explode('-', $_POST['date_range']);

		$minvalue = date('Y-m-d', strtotime($daterange[0])) . ' 00:00:00';

		$maxvalue = date('Y-m-d', strtotime($daterange[1])) . ' 23:59:00';



		$bda = true;

		$pa = true;

		$docv = true;

		$sa = true;



		if ($_POST['page'] == 'all_users') {

			$users = $this->User_model->getusersByStatusByDateRange('ALL', $minvalue, $maxvalue);
		}

		if ($_POST['page'] == 'pending_users') {

			$users = $this->User_model->getusersByStatusByDateRange('PENDING', $minvalue, $maxvalue);
		}

		if ($_POST['page'] == 'document_pending') {

			$users = $this->User_model->getusersByStatusByDateRange('DPENDING', $minvalue, $maxvalue);
		}

		if ($_POST['page'] == 'approved_users') {

			$users = $this->User_model->getusersByStatusByDateRange('APPROVED', $minvalue, $maxvalue);
		}

		if ($_POST['page'] == 'rejected_users') {

			$users = $this->User_model->getusersByStatusByDateRange('REJECTED', $minvalue, $maxvalue);
		}



?>

		<table id="data-table-buttons" class="table table-centered table-bordered table-condensed table-nowrap table-responsive">

			<thead>

				<tr>

					<th>S.no</th>

					<th>Username</th>

					<th>Email</th>

					<th>city</th>

					<th>Mobile</th>

					<?php if ($bda) { ?>

						<th>Basic&nbsp;Detail&nbsp;Approval</th>

					<?php } ?>

					<?php if ($docv) { ?>

						<th>Document&nbsp;verification&nbsp;approval</th>

					<?php } ?>

					<?php if ($pa) { ?>

						<th>Pan&nbsp;Card&nbsp;approval</th>

					<?php } ?>

					<?php if ($sa) { ?>

						<th>Passbook&nbsp;approval</th>

					<?php } ?>

					<th>Date of Creation</th>


				</tr>

			</thead>

			<?php $sno = 0; ?>

			<tbody>

				<?php $i = 1;
				foreach (@$users as $u) { ?>

					<tr>

						<td><?= $i ?></td>

						<td><?= ($u['first_name'] ? $u['first_name'] : 'NA') . ' ' . @$u['last_name'] ?></td>

						<td><?= ($u['email'] ? $u['email'] : 'NA') ?></td>

						<td><?= ($u['city'] ? $u['city'] : 'NA') ?></td>

						<td><?= ($u['mobile'] ? $u['mobile'] : 'NA') ?></td>

						<?php if ($bda) { ?>

							<td id="bda_status_<?= $u['userid'] ?>">

								<?php if ($u['bda_status'] != 'NOT_AVAILABLE') {

									echo '<button type="button" class="btn btn-' . ($u['bda_status'] == 'PENDING' ? 'warning' : ($u['bda_status'] == 'APPROVED' ? 'success' : ($u['bda_status'] == 'REJECTED' ? 'danger' : 'default'))) . ' btn-sm" onclick="getUserDetail(' . $u['userid'] . ',`bda_status`)">View</button>';
								} else {

									echo '<small class="text-danger">Not&nbsp;Available</small>';
								} ?>

							</td>

						<?php } ?>

						<?php if ($docv) { ?>

							<td id="docv_status_<?= $u['userid'] ?>">

								<?php if ($u['aadhar_upload_status'] != 'NOT_AVAILABLE') {

									echo '<button type="button" class="btn btn-' . ($u['docv_status'] == 'PENDING' ? 'warning' : ($u['docv_status'] == 'APPROVED' ? 'success' : ($u['docv_status'] == 'REJECTED' ? 'danger' : 'default'))) . ' btn-sm" onclick="getUserDetail(' . $u['userid'] . ',`docv_status`)">View</button>';
								} else {

									echo '<small class="text-danger">Not&nbsp;Available</small>';
								} ?>

							</td>

						<?php } ?>

						<?php if ($pa) { ?>

							<td id="pan_card_approved_status_<?= $u['userid'] ?>">

								<?php if ($u['pan_card_approved_status'] != 'NOT_AVAILABLE') {

									echo '<button type="button" class="btn btn-' . ($u['pan_card_approved_status'] == 'PENDING' ? 'warning' : ($u['pan_card_approved_status'] == 'APPROVED' ? 'success' : ($u['pan_card_approved_status'] == 'REJECTED' ? 'danger' : 'default'))) . ' btn-sm" onclick="getUserDetail(' . $u['userid'] . ',`pan_card_approved_status`)">View</button>';
								} else {

									echo '<small class="text-danger">Not&nbsp;Available</small>';
								} ?>

							</td>

						<?php } ?>

						<?php if ($sa) { ?>

							<td id="passbook_approved_status_<?= $u['userid'] ?>">

								<?php if ($u['passbook_approved_status'] != 'NOT_AVAILABLE') {

									echo '<button type="button" class="btn btn-' . ($u['passbook_approved_status'] == 'PENDING' ? 'warning' : ($u['passbook_approved_status'] == 'APPROVED' ? 'success' : ($u['passbook_approved_status'] == 'REJECTED' ? 'danger' : 'default'))) . ' btn-sm" onclick="getUserDetail(' . $u['userid'] . ',`passbook_approved_status`)">View</button>';
								} else {

									echo '<small class="text-danger">Not&nbsp;Available</small>';
								} ?>

							</td>

						<?php } ?>

						<td><?= $u['userCreationDate'] ?></td>

						<!-- <td><a class='btn btn-info' href='<?//= base_url('admin/user/contacts/' . $u['userid']) ?>'>View Contacts</a></td> -->

					</tr>

				<?php $i++;
				} ?>

			</tbody>

		</table>

		<?php





	}









	public function getUserDetail()
	{

		$userid = $_POST['userid'];

		// echo $userid;

		$user = $this->User_model->GetUserById($userid);

		if ($_POST['status'] == 'bda_status') { ?>

			<div class="modal-header">

				<h4 class="modal-title">Basic Detail Approval Form</h4>

				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

			</div>

			<form onsubmit='return updateUserdetails(this)' method='POST' data-userid='<?= $user->userid ?>'>

				<div class="modal-body">

					<div class="row">

						<div class="col-sm-12 col-md-6">

							<label>User First Name: </label>

							<div class="form-group">

								<input type="hidden" value="<?= $_POST['status'] ?>" class="form-control" name='doc_type'>

								<input name='first_name' type="text" placeholder="User First Name" value="<?= $user->first_name ?>" class="form-control" required>

							</div>

						</div>

						<div class="col-sm-12 col-md-6">

							<label>User last Name: </label>

							<div class="form-group">

								<input name='last_name' type="text" placeholder="User last Name" value="<?= $user->last_name ?>" class="form-control" required>

							</div>

						</div>

						<div class="col-sm-12 col-md-6">

							<label>Date of Birth:</label>

							<div class="form-group">

								<input name='dob' type="date" placeholder="date of birth" value="<?= $user->dob ?>" class="form-control" required>

							</div>

						</div>

						<div class="col-sm-12">

							<label>Address: </label>

							<div class="form-group">

								<textarea name='address' placeholder="Address" class="form-control" required><?= $user->address ?></textarea>

							</div>

						</div>

					</div>

				</div>



				<div class="modal-header">

					<h4 class="modal-title">User Bank Details</h4>

				</div>

				<div class="modal-body">

					<div class="row">

						<div class="col-sm-12 col-md-6">

							<label>Bank Name: </label>

							<div class="form-group">

								<input name='bank_name' type="text" placeholder="Bank Name" value="<?= $user->bank_name ?>" class="form-control" required>

							</div>

						</div>

						<div class="col-sm-12 col-md-6">

							<label>Account Holder Name: </label>

							<div class="form-group">

								<input name='acc_holder_name' type="text" placeholder="Account Holder Name" value="<?= $user->acc_holder_name ?>" class="form-control" required>

							</div>

						</div>

						<div class="col-sm-12 col-md-6">

							<label>Account Number </label>

							<div class="form-group">

								<input name='acc_no' type="text" placeholder="date of birth" value="<?= $user->acc_no ?>" class="form-control" required>

							</div>

						</div>

						<div class="col-sm-12 col-md-6">

							<label>IFSC Code: </label>

							<div class="form-group">

								<input name='ifcs_code' type="text" placeholder="Address" value="<?= $user->ifcs_code ?>" class="form-control" required>

							</div>

						</div>

					</div>

				</div>

				<div class="modal-header">

					<h4 class="modal-title">Emergency Contact</h4>

				</div>

				<div class="modal-body">

					<div class="row">

						<div class="col-sm-12 col-md-6">

							<label>Emergency Contact Name 1 </label>

							<div class="form-group">

								<input name='ecr1' type="text" placeholder="Emergency Contact Name 1" value="<?= $user->ecr1 ?>" class="form-control" required>

							</div>

						</div>

						<div class="col-sm-12 col-md-6">

							<label>Emergency Contact Mobile 1</label>

							<div class="form-group">

								<input name='ec1' type="text" placeholder="Emergency Contact Mobile 1" value="<?= $user->ec1 ?>" class="form-control" required>

							</div>

						</div>

						<div class="col-sm-12 col-md-6">

							<label>Emergency Contact Name 2</label>

							<div class="form-group">

								<input name='ecr2' type="text" placeholder="Emergency Contact Name 2" value="<?= $user->ecr2 ?>" class="form-control" required>

							</div>

						</div>

						<div class="col-sm-12 col-md-6">

							<label>Emergency Contact Mobile 2 </label>

							<div class="form-group">

								<input name='ec2' type="text" placeholder="Emergency Contact Mobile 2 " value="<?= $user->ec2 ?>" class="form-control" required>

							</div>

						</div>

					</div>

				</div>

				<div class="modal-header">

					<h4 class="modal-title">Company Details</h4>

				</div>

				<div class="modal-body">

					<div class='row'>



						<div class="col-12 col-md-6">

							<label>Company Name: </label>

							<div class="form-group">

								<input type="text" name='company_name' placeholder="Company Name" value="<?= $user->company_name ?>" class="form-control">

							</div>

						</div>

						<div class="col-12 col-md-6">

							<label>Job Type: </label>

							<div class="form-group">

								<input type="text" name='job_type' placeholder="Job Type" value="<?= $user->job_type ?>" class="form-control">

							</div>

						</div>

						<div class="col-12 col-md-6">

							<label>Office Telephone</label>

							<div class="form-group">

								<input type="text" name='office_telephone' placeholder="Office Telephone" value="<?= $user->office_telephone ?>" class="form-control">

							</div>

						</div>

						<div class="col-12 col-md-6">

							<label>industry: </label>

							<div class="form-group">

								<input type="text" name='industry' placeholder="industry" value="<?= $user->industry ?>" class="form-control">

							</div>

						</div>

						<div class="col-12 col-md-6">

							<label>Sallery: </label>

							<div class="form-group">

								<input type="text" name='monthly_salary' placeholder="sallery" value="<?= $user->monthly_salary ?>" class="form-control">

							</div>

						</div>

						<div class="col-12 col-md-6">

							<label>Years Of Working: </label>

							<div class="form-group">

								<input type="text" name='years_of_working' placeholder="Years Of Working" value="<?= $user->years_of_working ?>" class="form-control">

							</div>

						</div>

						<div class="col-12 col-md-6">

							<label>occupation: </label>

							<div class="form-group">

								<input type="text" name='occupation' placeholder="occupation" value="<?= $user->occupation ?>" class="form-control">

							</div>

						</div>

						<div class="col-12">

							<label>Company Address: </label>

							<div class="form-group">

								<textarea type="text" name='company_address' placeholder="company address" class="form-control"><?= $user->company_address ?></textarea>

							</div>

						</div>

					</div>

				</div>

				<div class="modal-footer d-block">

					<button type='submit' class='btn btn-info btn-sm pull-left m-t-5 m-b-5'>Update Data</button>

					<button type='button' class="btn btn-success pull-right btn-sm m-t-5 m-b-5" onclick="UpdateDocumentStatus('bda_status','APPROVED',<?= $userid ?>)">Approve</button>

					<button type='button' class="btn btn-danger pull-right btn-sm m-t-5 m-b-5" onclick="UpdateDocumentStatus('bda_status','REJECTED',<?= $userid ?>)">Reject</button>

				</div>

			</form>

		<?php }

		if ($_POST['status'] == 'pan_card_approved_status') { ?>

			<div class="modal-header">

				<h4 class="modal-title">Pan Card Approval Form</h4>

				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

			</div>

			<div class="modal-body">


				<form onsubmit='return updateUserdetails(this)' method='POST' data-userid='<?= $user->userid ?>'>

					<div class='row'>

						<div class='col-12'>

							<lable>Pan Card Image</lable>

							<?= ($user->pan_card_image ? '<a href="' . base_url('uploads/pan_card_image/' . $user->pan_card_image) . '" download class="badge badge-info d-flex align-items-center pull-right m-b-10 justify-content-center">Download File <i class="fa fa-download m-l-5"></i></a>' : '') ?>



							<a data-lightbox="example" href="<?= ($user->pan_card_image ? base_url('uploads/pan_card_image/' . $user->pan_card_image) : base_url('assets/img/image_not_available.png')) ?>">

								<img class="img-thumbnail" src="<?= ($user->pan_card_image ? base_url('uploads/pan_card_image/' . $user->pan_card_image) : base_url('assets/img/image_not_available.png')) ?>">

							</a>

							<div class='form-group m-t-10'>

								<label>Edit Pan Card Image</label>

								<input type="hidden" value="<?= $_POST['status'] ?>" class="form-control" name='doc_type'>

								<input type='file' name='pan_card_image' class='form-control'>

							</div>

						</div>

						<div class='col-12'>

							<a class="btn btn-success btn-sm m-t-5 m-b-5" href="javascript:UpdateDocumentStatus('pan_card_approved_status','APPROVED',<?= $userid ?>)">Approve</a>

							<a class="btn btn-danger btn-sm m-t-5 m-b-5" href="javascript:UpdateDocumentStatus('pan_card_approved_status','REJECTED',<?= $userid ?>)">Reject</a>

						</div>

						<div class='col-12'>

							<input type='submit' class='btn btn-info btn-sm pull-right m-t-5 m-b-5' value='Update Data'>

						</div>

					</div>

				</form>
			</div>


		<?php }

		if ($_POST['status'] == 'docv_status') { ?>

			<div class="modal-header">

				<h4 class="modal-title">Document Approval Form</h4>

				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

			</div>

			<div class="modal-body">

				<form class='mb-0' onsubmit='return updateUserdetails(this)' method='POST' data-userid='<?= $user->userid ?>'>

					<div class='row'>

						<div class='col-6'>

							<lable>Aadhar Card Front</lable>

							<?= ($user->adhar_card_front ? '<a href="' . base_url('uploads/adhar_card/front/' . $user->adhar_card_front) . '" download class="badge badge-info d-flex align-items-center pull-right m-b-10 justify-content-center">Download File <i class="fa fa-download m-l-5"></i></a>' : '') ?>



							<a data-lightbox="example" href="<?= ($user->adhar_card_front ? base_url('uploads/adhar_card/front/' . $user->adhar_card_front) : base_url('assets/img/image_not_available.png')) ?>">

								<img class="img-thumbnail" src="<?= ($user->adhar_card_front ? base_url('uploads/adhar_card/front/' . $user->adhar_card_front) : base_url('assets/img/image_not_available.png')) ?>">

							</a>

							<div class='form-group m-t-10'>

								<label>Edit Aadhar card front</label>

								<input type="hidden" value="<?= $_POST['status'] ?>" class="form-control" name='doc_type'>

								<input type='file' name='adhar_card_front' class='form-control'>

							</div>

						</div>

						<div class='col-6'>

							<lable>Aadhar Card Back</lable>

							<?= ($user->adhar_card_back ? '<a href="' . base_url('uploads/adhar_card/back/' . $user->adhar_card_back) . '" download class="badge badge-info d-flex align-items-center pull-right m-b-10 justify-content-center">Download File <i class="fa fa-download m-l-5"></i></a>' : '') ?>



							<a data-lightbox="example" href="<?= ($user->adhar_card_back ? base_url('uploads/adhar_card/back/' . $user->adhar_card_back) : base_url('assets/img/image_not_available.png')) ?>">

								<img class="img-thumbnail" src="<?= ($user->adhar_card_back ? base_url('uploads/adhar_card/back/' . $user->adhar_card_back) : base_url('assets/img/image_not_available.png')) ?>">

							</a>

							<div class='form-group m-t-10'>

								<label>Edit Aadhar card back</label>

								<input type='file' name='adhar_card_back' class='form-control'>

							</div>

						</div>

						<div class='col-6'>

							<input type='submit' class='btn btn-info btn-sm pull-left m-t-5 m-b-5' value='Update Data'>

						</div>



						<div class='col-6'>

							<a class="btn btn-success btn-sm m-t-5 m-b-5 pull-right" href="javascript:UpdateDocumentStatus('docv_status','APPROVED',<?= $userid ?>)">Approve</a>

							<a class="btn btn-danger btn-sm m-t-5 m-r-5 m-b-5 pull-right" href="javascript:UpdateDocumentStatus('docv_status','REJECTED',<?= $userid ?>)">Reject</a>

						</div>

					</div>

				</form>

			</div>

		<?php }

		if ($_POST['status'] == 'passbook_approved_status') { ?>

			<div class="modal-header">

				<h4 class="modal-title">Passbook Approval Form</h4>

				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

			</div>

			<div class="modal-body">

				<form onsubmit='return updateUserdetails(this)' method='POST' data-userid='<?= $user->userid ?>'>

					<div class='row'>

						<div class='col-12'>

							<lable>Passbook Image</lable>

							<?= ($user->passbook_image ? '<a href="' . base_url('uploads/passbook_image/' . $user->passbook_image) . '" download class="badge badge-info d-flex align-items-center pull-right m-b-10 justify-content-center">Download File <i class="fa fa-download m-l-5"></i></a>' : '') ?>



							<a data-lightbox="example" href="<?= ($user->passbook_image ? base_url('uploads/passbook_image/' . $user->passbook_image) : base_url('assets/img/image_not_available.png')) ?>">

								<img class="img-thumbnail" src="<?= ($user->passbook_image ? base_url('uploads/passbook_image/' . $user->passbook_image) : base_url('assets/img/image_not_available.png')) ?>">

							</a>

							<div class='form-group m-t-10'>

								<label>Edit Passbook Image</label>

								<input type="hidden" value="<?= $_POST['status'] ?>" class="form-control" name='doc_type'>

								<input type='file' name='passbook_image' class='form-control'>

							</div>

						</div>

						<div class='col-12'>

							<a class="btn btn-success btn-sm m-t-5 m-b-5" href="javascript:UpdateDocumentStatus('passbook_approved_status','APPROVED',<?= $userid ?>)">Approve</a>

							<a class="btn btn-danger btn-sm m-t-5 m-b-5" href="javascript:UpdateDocumentStatus('passbook_approved_status','REJECTED',<?= $userid ?>)">Reject</a>

						</div>

						<div class='col-12'>

							<input type='submit' class='btn btn-info btn-sm pull-right m-t-5 m-b-5' value='Update Data'>

						</div>

					</div>

				</form>

			</div>

		<?php }

		if ($_POST['status'] == 'all') { ?>

			<div class="modal-header">

				<h4 class="modal-title">User Details</h4>

				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

			</div>



			<div class="modal-body p-0 b-r-0">

				<div id="accordion" class="accordion">

					<div class="card" style='border-radius:0;cursor:pointer;'>

						<div class="card-header bg-white pointer-cursorcollapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false">

							<p class=' d-flex align-items-center m-b-0'><i class="fa fa-circle fa-fw text-blue mr-2 f-s-8"></i> Basic Details / Emergency Contacts / Company Details</p>

							<?= ($user->bda_status_comment != NULL ? '<small class="text-danger p-l-15">' . $user->bda_status_comment . '</small>' : '') ?>



						</div>

						<div id="collapseOne" class="collapse" data-parent="#accordion" style="">

							<div class="card-body">

								<form onsubmit='return updateUserdetails(this)' method='POST' data-userid='<?= $user->userid ?>'>

									<div class="row">

										<div class="col-12 col-md-6">

											<label>User First Name: </label>

											<div class="form-group">

												<input type="hidden" value="<?= $_POST['status'] ?>" class="form-control" name='doc_type'>

												<input type="text" name='first_name' placeholder="User First Name" value="<?= $user->first_name ?>" class="form-control">

											</div>

										</div>

										<div class="col-12 col-md-6">

											<label>User last Name: </label>

											<div class="form-group">

												<input type="text" name='last_name' placeholder="Nominee User last Name" value="<?= $user->last_name ?>" class="form-control">

											</div>

										</div>

										<div class="col-12 col-md-6">

											<label>Date of Birth: </label>

											<div class="form-group">

												<input type="text" name='dob' placeholder="Nominee date of birth" value="<?= $user->dob ?>" class="form-control">

											</div>

										</div>

										<div class="col-12 col-md-6">

											<label>Address: </label>

											<div class="form-group">

												<input type="text" name='address' placeholder="Nominee Address" value="<?= $user->address ?>" class="form-control">

											</div>

										</div>

										<div class="col-12 col-md-6">

											<label>Bank Name: </label>

											<div class="form-group">

												<input type="text" name='bank_name' placeholder="Bank Name" value="<?= $user->bank_name ?>" class="form-control">

											</div>

										</div>

										<div class="col-12 col-md-6">

											<label>Account Holder Name: </label>

											<div class="form-group">

												<input type="text" name='acc_holder_name' placeholder="Account Holder Name" value="<?= $user->acc_holder_name ?>" class="form-control">

											</div>

										</div>

										<div class="col-12 col-md-6">

											<label>Account Number </label>

											<div class="form-group">

												<input type="text" name='acc_no' placeholder="date of birth" value="<?= $user->acc_no ?>" class="form-control">

											</div>

										</div>

										<div class="col-12 col-md-6">

											<label>IFSC Code: </label>

											<div class="form-group">

												<input type="text" name='ifcs_code' placeholder="Address" value="<?= $user->ifcs_code ?>" class="form-control">

											</div>

										</div>

										<div class="col-12 col-md-6">

											<label>Emergency Contact Name 1 </label>

											<div class="form-group">

												<input type="text" name='ecr1' placeholder="Emergency Contact Name 1" value="<?= $user->ecr1 ?>" class="form-control">

											</div>

										</div>

										<div class="col-12 col-md-6">

											<label>Emergency Contact Mobile 1</label>

											<div class="form-group">

												<input type="text" name='ec1' placeholder="Emergency Contact Mobile 1" value="<?= $user->ec1 ?>" class="form-control">

											</div>

										</div>

										<div class="col-12 col-md-6">

											<label>Emergency Contact Name 2</label>

											<div class="form-group">

												<input type="text" name='ecr2' placeholder="Emergency Contact Name 2" value="<?= $user->ecr2 ?>" class="form-control">

											</div>

										</div>

										<div class="col-12 col-md-6">

											<label>Emergency Contact Mobile 2 </label>

											<div class="form-group">

												<input type="text" name='ec2' placeholder="Emergency Contact Mobile 2 " value="<?= $user->ec2 ?>" class="form-control">

											</div>

										</div>

										<div class="col-12 col-md-6">

											<label>Company Name: </label>

											<div class="form-group">

												<input type="text" name='company_name' placeholder="Company Name" value="<?= $user->company_name ?>" class="form-control">

											</div>

										</div>

										<div class="col-12 col-md-6">

											<label>Job Type: </label>

											<div class="form-group">

												<input type="text" name='job_type' placeholder="Job Type" value="<?= $user->job_type ?>" class="form-control">

											</div>

										</div>

										<div class="col-12 col-md-6">

											<label>Office Telephone</label>

											<div class="form-group">

												<input type="number" name='office_telephone' placeholder="Office Telephone" value="<?= $user->office_telephone ?>" class="form-control">

											</div>

										</div>

										<div class="col-12 col-md-6">

											<label>industry: </label>

											<div class="form-group">

												<input type="text" name='industry' placeholder="industry" value="<?= $user->industry ?>" class="form-control">

											</div>

										</div>

										<div class="col-12 col-md-6">

											<label>Salary: </label>

											<div class="form-group">

												<input type="number" name='monthly_salary' placeholder="sallery" value="<?= $user->monthly_salary ?>" class="form-control">

											</div>

										</div>

										<div class="col-12 col-md-6">

											<label>Years Of Working: </label>

											<div class="form-group">

												<input type="number" name='years_of_working' placeholder="Years Of Working" value="<?= $user->years_of_working ?>" class="form-control">

											</div>

										</div>

										<div class="col-12 col-md-6">

											<label>occupation: </label>

											<div class="form-group">

												<input type="text" name='occupation' placeholder="occupation" value="<?= $user->occupation ?>" class="form-control">

											</div>

										</div>

										<div class="col-12">

											<label>Company Address: </label>

											<div class="form-group">

												<textarea type="text" name='company_address' placeholder="company_address" class="form-control"><?= $user->company_address ?></textarea>

											</div>

										</div>

										<div class='col-6'>

											<a class="btn btn-success btn-sm m-t-5 m-b-5" href="javascript:UpdateDocumentStatus('bda_status','APPROVED',<?= $userid ?>)">Approve</a>

											<a class="btn btn-danger btn-sm m-t-5 m-b-5" href="javascript:UpdateDocumentStatus('bda_status','REJECTED',<?= $userid ?>)">Reject</a>

										</div>

										<div class='col-6'>

											<input type='submit' class='btn btn-info btn-sm pull-right m-t-5 m-b-5' value='Update Data'>

										</div>

									</div>

								</form>

							</div>

						</div>

					</div>

					<div class="card" style='cursor:pointer;'>

						<div class="card-header bg-white pointer-cursor collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false">

							<p class='d-flex align-items-center m-b-0'><i class="fa fa-circle fa-fw text-danger mr-2 f-s-8"></i> Aadhar Documents</p>

							<?= ($user->docv_status_comment != NULL ? '<small class="text-danger p-l-15">' . $user->docv_status_comment . '</small>' : '') ?>

						</div>

						<div id="collapseSix" class="collapse" data-parent="#accordion" style="">

							<div class="card-body">

								<form onsubmit='return updateUserdetails(this)' method='POST' data-userid='<?= $user->userid ?>'>

									<div class='row'>

										<div class='col-6'>

											<lable>Aadhar Card Front</lable>

											<?= ($user->adhar_card_front ? '<a href="' . base_url('uploads/adhar_card/front/' . $user->adhar_card_front) . '" download class="badge badge-info d-flex align-items-center pull-right m-b-10 justify-content-center">Download File <i class="fa fa-download m-l-5"></i></a>' : '') ?>



											<a data-lightbox="example" href="<?= ($user->adhar_card_front ? base_url('uploads/adhar_card/front/' . $user->adhar_card_front) : base_url('assets/img/image_not_available.png')) ?>">

												<img class="img-thumbnail" src="<?= ($user->adhar_card_front ? base_url('uploads/adhar_card/front/' . $user->adhar_card_front) : base_url('assets/img/image_not_available.png')) ?>">

											</a>

											<div class='form-group m-t-10'>

												<label>Edit Aadhar card front</label>

												<input type="hidden" value="<?= $_POST['status'] ?>" class="form-control" name='doc_type'>

												<input type='file' name='adhar_card_front' class='form-control'>

											</div>

										</div>

										<div class='col-6'>

											<lable>Aadhar Card Back</lable>

											<?= ($user->adhar_card_back ? '<a href="' . base_url('uploads/adhar_card/back/' . $user->adhar_card_back) . '" download class="badge badge-info d-flex align-items-center pull-right m-b-10 justify-content-center">Download File <i class="fa fa-download m-l-5"></i></a>' : '') ?>



											<a data-lightbox="example" href="<?= ($user->adhar_card_back ? base_url('uploads/adhar_card/back/' . $user->adhar_card_back) : base_url('assets/img/image_not_available.png')) ?>">

												<img class="img-thumbnail" src="<?= ($user->adhar_card_back ? base_url('uploads/adhar_card/back/' . $user->adhar_card_back) : base_url('assets/img/image_not_available.png')) ?>">

											</a>

											<div class='form-group m-t-10'>

												<label>Edit Aadhar card back</label>

												<input type='file' name='adhar_card_back' class='form-control'>

											</div>

										</div>

										<div class='col-6'>

											<a class="btn btn-success btn-sm m-t-5 m-b-5" href="javascript:UpdateDocumentStatus('docv_status','APPROVED',<?= $userid ?>)">Approve</a>

											<a class="btn btn-danger btn-sm m-t-5 m-b-5" href="javascript:UpdateDocumentStatus('docv_status','REJECTED',<?= $userid ?>)">Reject</a>

										</div>

										<div class='col-6'>

											<input type='submit' class='btn btn-info btn-sm pull-right m-t-5 m-b-5' value='Update Data'>

										</div>

									</div>

								</form>

							</div>

						</div>

					</div>

					<div class="card" style='cursor:pointer;'>

						<div class="card-header bg-white pointer-cursor collapsed" data-toggle="collapse" data-target="#collapsePanCard" aria-expanded="false">

							<p class='d-flex align-items-center m-b-0'><i class="fa fa-circle fa-fw text-danger mr-2 f-s-8"></i>Pan Card Image</p>

							<?= ($user->pan_card_approved_status_comment != NULL ? '<small class="text-danger p-l-15">' . $user->pan_card_approved_status_comment . '</small>' : '') ?>

						</div>

						<div id="collapsePanCard" class="collapse" data-parent="#accordion">

							<div class="card-body">

								<form onsubmit='return updateUserdetails(this)' method='POST' data-userid='<?= $user->userid ?>'>

									<div class='row'>

										<div class='col-12'>

											<lable>Pan Card Image</lable>

											<?= ($user->pan_card_image ? '<a href="' . base_url('uploads/pan_card_image/' . $user->pan_card_image) . '" download class="badge badge-info d-flex align-items-center pull-right m-b-10 justify-content-center">Download File <i class="fa fa-download m-l-5"></i></a>' : '') ?>



											<a data-lightbox="example" href="<?= ($user->pan_card_image ? base_url('uploads/pan_card_image/' . $user->pan_card_image) : base_url('assets/img/image_not_available.png')) ?>">

												<img class="img-thumbnail" src="<?= ($user->pan_card_image ? base_url('uploads/pan_card_image/' . $user->pan_card_image) : base_url('assets/img/image_not_available.png')) ?>">

											</a>

											<div class='form-group m-t-10'>

												<label>Edit Pan Card Image</label>

												<input type="hidden" value="<?= $_POST['status'] ?>" class="form-control" name='doc_type'>

												<input type='file' name='pan_card_image' class='form-control'>

											</div>

										</div>

										<div class='col-12'>

											<a class="btn btn-success btn-sm m-t-5 m-b-5" href="javascript:UpdateDocumentStatus('pan_card_approved_status','APPROVED',<?= $userid ?>)">Approve</a>

											<a class="btn btn-danger btn-sm m-t-5 m-b-5" href="javascript:UpdateDocumentStatus('pan_card_approved_status','REJECTED',<?= $userid ?>)">Reject</a>

										</div>

										<div class='col-12'>

											<input type='submit' class='btn btn-info btn-sm pull-right m-t-5 m-b-5' value='Update Data'>

										</div>

									</div>

								</form>

							</div>

						</div>

					</div>

					<div class="card" style='cursor:pointer;'>

						<div class="card-header bg-white pointer-cursor collapsed" data-toggle="collapse" data-target="#collapsePassbook" aria-expanded="false">

							<p class='d-flex align-items-center m-b-0'><i class="fa fa-circle fa-fw text-danger mr-2 f-s-8"></i>Passbook Image</p>

							<?= ($user->passbook_approved_status_comment != NULL ? '<small class="text-danger p-l-15">' . $user->passbook_approved_status_comment . '</small>' : '') ?>

						</div>

						<div id="collapsePassbook" class="collapse" data-parent="#accordion">

							<div class="card-body">

								<form onsubmit='return updateUserdetails(this)' method='POST' data-userid='<?= $user->userid ?>'>

									<div class='row'>

										<div class='col-12'>

											<lable>Passbook Image</lable>

											<?= ($user->passbook_image ? '<a href="' . base_url('uploads/passbook_image/' . $user->passbook_image) . '" download class="badge badge-info d-flex align-items-center pull-right m-b-10 justify-content-center">Download File <i class="fa fa-download m-l-5"></i></a>' : '') ?>



											<a data-lightbox="example" href="<?= ($user->passbook_image ? base_url('uploads/passbook_image/' . $user->passbook_image) : base_url('assets/img/image_not_available.png')) ?>">

												<img class="img-thumbnail" src="<?= ($user->passbook_image ? base_url('uploads/passbook_image/' . $user->passbook_image) : base_url('assets/img/image_not_available.png')) ?>">

											</a>

											<div class='form-group m-t-10'>

												<label>Edit Passbook Image</label>

												<input type="hidden" value="<?= $_POST['status'] ?>" class="form-control" name='doc_type'>

												<input type='file' name='passbook_image' class='form-control'>

											</div>

										</div>

										<div class='col-12'>

											<a class="btn btn-success btn-sm m-t-5 m-b-5" href="javascript:UpdateDocumentStatus('passbook_approved_status','APPROVED',<?= $userid ?>)">Approve</a>

											<a class="btn btn-danger btn-sm m-t-5 m-b-5" href="javascript:UpdateDocumentStatus('passbook_approved_status','REJECTED',<?= $userid ?>)">Reject</a>

										</div>

										<div class='col-12'>

											<input type='submit' class='btn btn-info btn-sm pull-right m-t-5 m-b-5' value='Update Data'>

										</div>

									</div>

								</form>

							</div>

						</div>

					</div>

				</div>

			</div>

<?php }
	}



	public function updateUserdetails($userid)
	{

		$userdata = $this->User_model->GetUserById($userid);

		if (isset($_POST) && !empty($_POST)) {

			$data = $_POST;

			unset($data['doc_type']);
		}

		if (!empty($_FILES['adhar_card_front']['name'])) {

			// Adhar card front

			$ext = pathinfo($_FILES['adhar_card_front']['name'], PATHINFO_EXTENSION);

			$filename = 'aadhar_car_front_image_' . rand('111111', '999999') . '_' . time() . '.' . $ext;

			$config = array(

				'file_name' => $filename,

				'upload_path' => "./uploads/adhar_card/front/",

				'allowed_types' => "gif|jpg|png|jpeg|svg",

				'overwrite' => TRUE

			);

			$this->upload->initialize($config);

			if ($this->upload->do_upload('adhar_card_front')) {

				if ($userdata->adhar_card_front != NULL) {

					if (file_exists('uploads/adhar_card/front/' . $userdata->adhar_card_front)) {

						unlink('uploads/adhar_card/front/' . $userdata->adhar_card_front);
					}
				}

				$data['adhar_card_front'] = $filename;
			}
		}

		if (!empty($_FILES['adhar_card_back']['name'])) {

			// Adhar card front

			$ext = pathinfo($_FILES['adhar_card_back']['name'], PATHINFO_EXTENSION);

			$filename = 'aadhar_card_back_image_' . rand('111111', '999999') . '_' . time() . '.' . $ext;

			$config = array(

				'file_name' => $filename,

				'upload_path' => "./uploads/adhar_card/back/",

				'allowed_types' => "gif|jpg|png|jpeg|svg",

				'overwrite' => TRUE

			);

			$this->upload->initialize($config);

			if ($this->upload->do_upload('adhar_card_back')) {

				if ($userdata->adhar_card_back != NULL) {

					if (file_exists('uploads/adhar_card/back/' . $userdata->adhar_card_back)) {

						unlink('uploads/adhar_card/back/' . $userdata->adhar_card_back);
					}
				}

				$data['adhar_card_back'] = $filename;
			}
		}



		// -------------------------------

		if (!empty($_FILES['pan_card_image']['name'])) {

			// Adhar card front

			$ext = pathinfo($_FILES['pan_card_image']['name'], PATHINFO_EXTENSION);

			$filename = 'pan_card_image_image_' . rand('111111', '999999') . '_' . time() . '.' . $ext;

			$config = array(

				'file_name' => $filename,

				'upload_path' => "./uploads/pan_card_image/",

				'allowed_types' => "gif|jpg|png|jpeg|svg",

				'overwrite' => TRUE

			);

			$this->upload->initialize($config);

			if ($this->upload->do_upload('pan_card_image')) {

				if ($userdata->pan_card_image != NULL) {

					if (file_exists('uploads/pan_card_image/' . $userdata->pan_card_image)) {

						unlink('uploads/pan_card_image/' . $userdata->pan_card_image);
					}
				}

				$data['pan_card_image'] = $filename;
			}
		}


		if (!empty($_FILES['passbook_image']['name'])) {

			// Adhar card front

			$ext = pathinfo($_FILES['passbook_image']['name'], PATHINFO_EXTENSION);

			$filename = 'passbook_image_image_' . rand('111111', '999999') . '_' . time() . '.' . $ext;

			$config = array(

				'file_name' => $filename,

				'upload_path' => "./uploads/passbook_image/",

				'allowed_types' => "gif|jpg|png|jpeg|svg",

				'overwrite' => TRUE

			);

			$this->upload->initialize($config);

			if ($this->upload->do_upload('passbook_image')) {

				if ($userdata->passbook_image != NULL) {

					if (file_exists('uploads/passbook_image/' . $userdata->passbook_image)) {

						unlink('uploads/passbook_image/' . $userdata->passbook_image);
					}
				}

				$data['passbook_image'] = $filename;
			}
		}

		// -------------------------------



		if (!empty($_FILES['profile_image']['name'])) {

			// Adhar card front

			$ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);

			$filename = 'profile_image_' . rand('111111', '999999') . '_' . time() . '.' . $ext;

			$config = array(

				'file_name' => $filename,

				'upload_path' => "./uploads/profile_image/",

				'allowed_types' => "gif|jpg|png|jpeg|svg",

				'overwrite' => TRUE

			);

			$this->upload->initialize($config);

			if ($this->upload->do_upload('profile_image')) {

				if ($userdata->profile_image != NULL) {

					if (file_exists('uploads/profile_image/' . $userdata->profile_image)) {

						unlink('uploads/profile_image/' . $userdata->profile_image);
					}
				}

				$data['profile_image'] = $filename;
			}
		}

		if (!empty($_FILES['pay_slip_image']['name'])) {

			// Adhar card front

			$ext = pathinfo($_FILES['pay_slip_image']['name'], PATHINFO_EXTENSION);

			$filename = 'pay_slip_image_image_' . rand('111111', '999999') . '_' . time() . '.' . $ext;

			$config = array(

				'file_name' => $filename,

				'upload_path' => "./uploads/pay_slip_image/",

				'allowed_types' => "gif|jpg|png|jpeg|svg|pdf",

				'overwrite' => TRUE

			);

			$this->upload->initialize($config);

			if ($this->upload->do_upload('pay_slip_image')) {

				if ($userdata->pay_slip_image != NULL) {

					if (file_exists('uploads/pay_slip_image/' . $userdata->pay_slip_image)) {

						unlink('uploads/pay_slip_image/' . $userdata->pay_slip_image);
					}
				}

				$data['pay_slip_image'] = $filename;
			}
		}

		$sql = $this->User_model->updateUserDataByUserId($userid, $data);

		if ($sql) {

			$error['status'] = false;

			$error['message'] = 'User Profile Updated Successfully';

			$error['doc_type'] = $_POST['doc_type'];
		} else {

			$error['status'] = true;

			$error['message'] = 'Unable to update user profile';
		}

		echo json_encode($error);
	}

	public function UpdateDocumentStatus()
	{



		$data[$_POST['col_name']] = $_POST['value'];

		$data[$_POST['col_name'] . '_comment'] = $_POST['message'];

		$sql = $this->User_model->updateUserDataByUserId($_POST['userid'], $data);

		if ($sql) {

			$candata = [];

			$user = $this->User_model->GetUserById($_POST['userid']);

			if (
				$user->bda_status == 'APPROVED' &&

				$user->ecv_status == 'APPROVED' &&

				$user->ba_status == 'APPROVED' &&

				$user->pa_status == 'APPROVED' &&

				$user->docv_status == 'APPROVED' &&

				$user->docv_status == 'APPROVED' &&

				$user->pan_card_approved_status == 'APPROVED' &&

				$user->passbook_approved_status == 'APPROVED'
			) {

				$candata['cpa_status'] = 'VERIFIED';
			} else {

				$candata['cpa_status'] = 'NOT_VERIFIED';
			}

			if (!empty($candata)) {

				$this->User_model->updateUserDataByUserId($_POST['userid'], $candata);
			}

			$arrNotification = [];

			$user = $this->User_model->GetUserById($_POST['userid']);

			if ($_POST['col_name'] == 'bda_status') {

				$arrNotification["title"]   =  "Your Basic details are " . ($user->bda_status == 'APPROVED' ? 'approved' : 'rejected');

				$message = ($user->bda_status == 'APPROVED' ? 'Your Basic details are Approved Successfully. Please wait for other documents to be approved by our team to take a loan.' : 'Your Basic details Is Rejected By our team. Please reupload your documents to get approved by our team to take a loan.Thanks');

				$error['data'] = '<button class="btn btn-' . ($user->bda_status == 'PENDING' ? 'warning' : ($user->bda_status == 'APPROVED' ? 'success' : 'danger')) . ' btn-sm" onclick="getUserDetail(' . $_POST['userid'] . ',`' . $_POST['col_name'] . '`);">View</button> ';
			} else if ($_POST['col_name'] == 'ecv_status') {

				$arrNotification["title"]   =  "Your Emergency contacts are " . ($user->ecv_status == 'APPROVED' ? 'approved' : 'rejected');

				$message = ($user->ecv_status == 'APPROVED' ? 'Your Emergency contacts are Approved Successfully. Please wait for other documents to be approved by our team to take a loan.' : 'Your Emergency contacts Is Rejected By our team. Please reupload your documents to get approved by our team to take a loan.Thanks');

				$error['data'] = '<button class="btn btn-' . ($user->ecv_status == 'PENDING' ? 'warning' : ($user->ecv_status == 'APPROVED' ? 'success' : 'danger')) . ' btn-sm" onclick="getUserDetail(' . $_POST['userid'] . ',`' . $_POST['col_name'] . '`);">View</button> ';
			} else if ($_POST['col_name'] == 'ba_status') {

				$arrNotification["title"]   =  "Your Bank details is " . ($user->ba_status == 'APPROVED' ? 'approved' : 'rejected');

				$message = ($user->ba_status == 'APPROVED' ? 'Your Bank details are Approved Successfully. Please wait for other documents to be approved by our team to take a loan.' : 'Your Bank details Is Rejected By our team. Please reupload your documents to get approved by our team to take a loan.Thanks');

				$error['data'] = '<button class="btn btn-' . ($user->ba_status == 'PENDING' ? 'warning' : ($user->ba_status == 'APPROVED' ? 'success' : 'danger')) . ' btn-sm" onclick="getUserDetail(' . $_POST['userid'] . ',`' . $_POST['col_name'] . '`);">View</button> ';
			} else if ($_POST['col_name'] == 'pa_status') {

				$arrNotification["title"]   =  "Your Pay slip details is " . ($user->pa_status == 'APPROVED' ? 'approved' : 'rejected');

				$message = ($user->pa_status == 'APPROVED' ? 'Your Pay slip Documents are Approved Successfully. Please wait for other documents to be approved by our team to take a loan.' : 'Your Pay slip Documents Is Rejected By our team. Please reupload your documents to get approved by our team to take a loan.Thanks');

				$error['data'] = '<button class="btn btn-' . ($user->pa_status == 'PENDING' ? 'warning' : ($user->pa_status == 'APPROVED' ? 'success' : 'danger')) . ' btn-sm" onclick="getUserDetail(' . $_POST['userid'] . ',`' . $_POST['col_name'] . '`);">View</button> ';
			} else if ($_POST['col_name'] == 'docv_status') {

				$arrNotification["title"]   =  "Your Aadhar documents details is " . ($user->docv_status == 'APPROVED' ? 'approved' : 'rejected');

				$message = ($user->docv_status == 'APPROVED' ? 'Your Aadhar documents are Approved Successfully. Please wait for other documents to be approved by our team to take a loan.' : 'Your Aadhar Documents Is Rejected By our team. Please reupload your documents to get approved by our team to take a loan.Thanks');

				$error['data'] = '<button class="btn btn-' . ($user->docv_status == 'PENDING' ? 'warning' : ($user->docv_status == 'APPROVED' ? 'success' : 'danger')) . ' btn-sm" onclick="getUserDetail(' . $_POST['userid'] . ',`' . $_POST['col_name'] . '`);">View</button> ';
			} else if ($_POST['col_name'] == 'sa_status') {

				$arrNotification["title"]   =  "Your selfie is " . ($user->sa_status == 'APPROVED' ? 'approved' : 'rejected');

				$message = ($user->sa_status == 'APPROVED' ? 'Your Selfie Is  Approved Successfully. Please wait for other documents to be approved by our team to take a loan.' : 'Your Selfie Is Rejected By our team. Please reupload your documents to get approved by our team to take a loan.Thanks');

				$error['data'] = '<button class="btn btn-' . ($user->sa_status == 'PENDING' ? 'warning' : ($user->sa_status == 'APPROVED' ? 'success' : 'danger')) . ' btn-sm" onclick="getUserDetail(' . $_POST['userid'] . ',`' . $_POST['col_name'] . '`);">View</button> ';
			} else if ($_POST['col_name'] == 'pan_card_approved_status') {

				$arrNotification["title"]   =  "Your Pan Card is " . ($user->pan_card_approved_status == 'APPROVED' ? 'approved' : 'rejected');

				$message = ($user->pan_card_approved_status == 'APPROVED' ? 'Your Pan Card Is  Approved Successfully. Please wait for other documents to be approved by our team to take a loan.' : 'Your Pan Card Is Rejected By our team. Please reupload your documents to get approved by our team to take a loan.Thanks');

				$error['data'] = '<button class="btn btn-' . ($user->pan_card_approved_status == 'PENDING' ? 'warning' : ($user->pan_card_approved_status == 'APPROVED' ? 'success' : 'danger')) . ' btn-sm" onclick="getUserDetail(' . $_POST['userid'] . ',`' . $_POST['col_name'] . '`);">View</button> ';
			} else if ($_POST['col_name'] == 'passbook_approved_status') {

				$arrNotification["title"]   =  "Your Passbook is " . ($user->passbook_approved_status == 'APPROVED' ? 'approved' : 'rejected');

				$message = ($user->passbook_approved_status == 'APPROVED' ? 'Your Passbook Is  Approved Successfully. Please wait for other documents to be approved by our team to take a loan.' : 'Your Passbook Is Rejected By our team. Please reupload your documents to get approved by our team to take a loan.Thanks');

				$error['data'] = '<button class="btn btn-' . ($user->passbook_approved_status == 'PENDING' ? 'warning' : ($user->passbook_approved_status == 'APPROVED' ? 'success' : 'danger')) . ' btn-sm" onclick="getUserDetail(' . $_POST['userid'] . ',`' . $_POST['col_name'] . '`);">View</button> ';
			}

			$arrNotification["sound"]   =  "default";

			$arrNotification["body"] = $message;

			$arrNotification["type"]    =  1;

			$arrNotification["action"]  =  "activity";

			$this->Notification_model->SendPushnotification($user->fcm_token, $arrNotification, 'Android');

			$userdata['default_title'] = $arrNotification["title"];

			$userdata['default_message'] = $message;

			$this->User_model->updateUserDataByUserId($_POST['userid'], $userdata);

			$error['status'] = false;

			$error['message'] = 'Status Updated Successfully';

			$error['col_id'] = $_POST['col_name'] . '_' . $_POST['userid'];
		} else {

			$error['status'] = true;

			$error['message'] = 'Status Not Updated';
		}



		echo json_encode($error);
	}



	public function contacts($user)
	{

		$this->data['page'] = 'app_installs';

		$this->data['user'] = $userData = $this->User_model->GetUserById($user);

		$this->data['page_title'] = 'View All Contacts of the user - ' . $userData->mobile;

		$this->data['contacts'] = $this->User_app_contacts_model->getAllContactsByUser($user);

		$this->load->view('admin/contacts', $this->data);
	}
}
