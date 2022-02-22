<div class="modal fade text-left" id="use_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9" aria-hidden="true">
    
										<div class="modal-dialog" role="document">
										<div class="modal-content" id="modal_contn">
					    
										</div>
										</div>
									</div>



    <!-- BEGIN: Vendor JS-->
    <script src="<?= base_url();?>app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
    <script src="<?= base_url();?>app-assets/vendors/js/forms/toggle/switchery.min.js" type="text/javascript"></script>
    <script src="<?= base_url();?>app-assets/js/scripts/forms/switch.min.js" type="text/javascript"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script type="text/javascript" src="<?= base_url();?>app-assets/vendors/js/ui/jquery.sticky.js"></script>
    <!--<script src="<?= base_url();?>app-assets/vendors/js/timeline/horizontal-timeline.js" type="text/javascript"></script>-->
    <!--<script src="<?= base_url();?>app-assets/vendors/js/tables/datatable/datatables.min.js" type="text/javascript"></script>-->
    <!-- <script src="<?= base_url();?>app-assets/vendors/js/tables/datatable/datatables.min.js" type="text/javascript"></script>
    <script src="<?= base_url();?>app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js" type="text/javascript"></script>
    <script src="<?= base_url();?>app-assets/vendors/js/tables/buttons.flash.min.js" type="text/javascript"></script>
    <script src="<?= base_url();?>app-assets/vendors/js/tables/jszip.min.js" type="text/javascript"></script>
    <script src="<?= base_url();?>app-assets/vendors/js/tables/pdfmake.min.js" type="text/javascript"></script>
    <script src="<?= base_url();?>app-assets/vendors/js/tables/vfs_fonts.js" type="text/javascript"></script>
    <script src="<?= base_url();?>app-assets/vendors/js/tables/buttons.html5.min.js" type="text/javascript"></script>
    <script src="<?= base_url();?>app-assets/js/scripts/tables/datatables/datatable-advanced.min.js" type="text/javascript"></script>
    <script src="<?= base_url();?>app-assets/vendors/js/tables/buttons.print.min.js" type="text/javascript"></script> -->
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="<?= base_url();?>app-assets/js/core/app-menu.min.js" type="text/javascript"></script>
    <script src="<?= base_url();?>app-assets/js/core/app.min.js" type="text/javascript"></script>
    <script src="<?= base_url();?>app-assets/js/scripts/customizer.min.js" type="text/javascript"></script>
    <script src="<?= base_url();?>app-assets/vendors/js/jquery.sharrre.js" type="text/javascript"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <!-- END: Page JS-->
    
<!-- <link rel="stylesheet" href="<?= base_url();?>rich_editor/rte_theme_default.css" />
<script type="text/javascript" src="<?= base_url();?>rich_editor/rte.js"></script>
<script type="text/javascript" src="<?= base_url();?>rich_editor/all_plugins.js"></script> -->

<script>
    $( document ).ready(function()
    {
        $( '#preloader-svg' ).hide();
        $( 'body' ).css( 'overflow', 'scroll' );

        $( 'a[href^="http"]' ).on( 'click', function()
        {
            $( '#preloader-svg' ).show();
            $( 'body' ).css( 'overflow', 'hidden' );
        });
    });
</script>

  </body>
  <!-- END: Body-->
</html>