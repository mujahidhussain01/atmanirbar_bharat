<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<div id="preloader-svg" style="height: 100vh; width:100vw; display:flex;justify-content:center;align-items:center;">

	<!-- 4 -->
	<div class="loader loader--style4" title="3">
		<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24px" height="24px" viewBox="0 0 24 24" style="enable-background:new 0 0 50 50;" xml:space="preserve">
			<rect x="0" y="0" width="4" height="7" fill="#333">
				<animateTransform attributeType="xml" attributeName="transform" type="scale" values="1,1; 1,3; 1,1" begin="0s" dur="0.6s" repeatCount="indefinite" />
			</rect>

			<rect x="10" y="0" width="4" height="7" fill="#333">
				<animateTransform attributeType="xml" attributeName="transform" type="scale" values="1,1; 1,3; 1,1" begin="0.2s" dur="0.6s" repeatCount="indefinite" />
			</rect>
			<rect x="20" y="0" width="4" height="7" fill="#333">
				<animateTransform attributeType="xml" attributeName="transform" type="scale" values="1,1; 1,3; 1,1" begin="0.4s" dur="0.6s" repeatCount="indefinite" />
			</rect>
		</svg>
	</div>
</div>

<head>
	<style>
		body {
			overflow: hidden;
		}
	</style>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta name="description" content="Chameleon Admin is a modern Bootstrap 4 webapp &amp; admin dashboard html template with a large number of components, elegant design, clean and organized code.">
	<meta name="keywords" content="admin template, Chameleon admin template, dashboard template, gradient admin template, responsive admin template, webapp, eCommerce dashboard, analytic dashboard">
	<meta name="author" content="ThemeSelect">
	<title>Assleit - Admin</title>
	<link rel="apple-touch-icon" href="<?= base_url(); ?>app-assets/images/ico/apple-icon-120.png">
	<link rel="shortcut icon" type="image/x-icon" href="https://themeselection.com/demo/chameleon-admin-template/app-assets/images/ico/favicon.ico">
	<link href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i%7CComfortaa:300,400,700" rel="stylesheet">

	<!-- BEGIN: Vendor CSS-->
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>app-assets/vendors/css/vendors.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>app-assets/vendors/css/forms/toggle/switchery.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>app-assets/css/plugins/forms/switch.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>app-assets/css/core/colors/palette-switch.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>app-assets/vendors/css/tables/datatable/datatables.min.css">
	<!-- END: Vendor CSS-->

	<!-- BEGIN: Theme CSS-->
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>app-assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>app-assets/css/bootstrap-extended.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>app-assets/css/colors.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>app-assets/css/components.min.css">
	<!-- END: Theme CSS-->

	<!-- BEGIN: Page CSS-->
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>app-assets/css/core/menu/menu-types/horizontal-menu.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>app-assets/css/core/colors/palette-gradient.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!--<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>app-assets/css/pages/timeline.min.css">-->
	<!-- END: Page CSS-->


</head>
<!-- END: Head-->
<style>
	#overlay {
		position: fixed;
		top: 0;
		z-index: 9999;
		width: 100%;
		height: 100%;
		display: none;
		background: white;
	}

	.cv-spinner {
		height: 100%;
		display: flex;
		justify-content: center;
		align-items: center;
	}

	.spinner {
		width: 40px;
		height: 40px;
		border: 4px #ddd solid;
		border-top: 4px #2e93e6 solid;
		border-radius: 50%;
		animation: sp-anime 0.8s infinite linear;
	}

	@keyframes sp-anime {
		100% {
			transform: rotate(360deg);
		}
	}

	.py-md-16 {
		padding-top: 3rem !important;
	}

	.mb-10 {
		margin-bottom: 10px !important;
	}

	.mt-10 {
		margin-top: 10px !important;
	}
	.content-wrapper-before
	{
	    background-image: linear-gradient(to right,#f68d1e,#2ea65d) !important;
	}
	
	.bg-gradient-x-purple-red
	{
	    background-image: linear-gradient(to right,#ed8e21,#e68d22) !important;
	}
</style>