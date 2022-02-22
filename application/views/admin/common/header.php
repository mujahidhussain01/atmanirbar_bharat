<?php include('sidebarcount.php'); ?><html>



	<head>

		<meta charset="utf-8" />

		<title>Atma Nirbhar Bharat | Dashboard</title>

		<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />

		<meta content="" name="description" />

		<meta content="" name="author" />

		<link rel="shortcut icon" href="<?php echo base_url()?>assets/img/favicon.ico" type="image/x-icon">

		<link rel="icon" href="<?php echo base_url()?>assets/img/favicon.ico" type="image/x-icon">

		<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet" />

		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />

		<link href="<?=base_url()?>assets/css/google/app.min.css" rel="stylesheet" />

        <link href="<?=base_url()?>assets/plugins/ionicons/css/ionicons.min.css" rel="stylesheet" />

		<link href="<?=base_url()?>assets/plugins/jvectormap-next/jquery-jvectormap.css" rel="stylesheet" />

		<link href="<?=base_url()?>assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css" rel="stylesheet" />

		<link href="<?=base_url()?>assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />

		<link href="<?=base_url()?>assets/plugins/nvd3/build/nv.d3.css" rel="stylesheet" />

		<link href="<?php echo base_url()?>assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />

		<link href="<?php echo base_url()?>assets/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />

		<link href="<?php echo base_url()?>assets/plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" />

		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" 

		integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">



		<style>

.dropdown-menu.media-list {

    max-width: 360px;

    padding: 0;

    min-width: 360px;

}

		</style>

	</head>

<body>

	<div id="page-loader" class="fade show">

		<span class="spinner"></span>

	</div>

	<div id="page-container" class="fade page-sidebar-fixed page-header-fixed page-with-wide-sidebar page-with-light-sidebar">

<div id="header" class="header navbar-default">

	<div class="navbar-header">

		<button type="button" class="navbar-toggle collapsed navbar-toggle-left" data-click="sidebar-minify">

		<span class="icon-bar"></span>

		<span class="icon-bar"></span>

		<span class="icon-bar"></span>

		</button>

		<a href="" class="navbar-brand">

			<img src="<?=base_url('images/aamjan-04.png')?>">

		</a>

		<button type="button" class="navbar-toggle" data-click="sidebar-toggled">

		<span class="icon-bar"></span>

		<span class="icon-bar"></span>

		<span class="icon-bar"></span>

		</button>

	</div>

	<ul class="navbar-nav" style="

    width: 80%;

    justify-content: flex-end;

">

		<li>

		    <a href="javascript:refreshPanelty()" type="button" data-toggle='tooltip' data-title='Refresh Panelty loans' class="navbar-brand">

			    <i class="ion ion-md-refresh" style='font-size:30px;'></i> 

		    </a>

		</li>

		<li class="dropdown navbar-user">

			<a href="#" class="dropdown-toggle" data-toggle="dropdown">

				<img src="<?=base_url()?>assets/img/user-avatar.png" alt="" />

				<span class="d-none d-md-inline">Welcome Admin</span> <b class="caret"></b>

			</a>

			<div class="dropdown-menu dropdown-menu-right">

				<a href="<?php echo base_url()?>admin/welcome/logout" class="dropdown-item">Log Out</a>

			</div>

		</li>

	</ul>

</div>

