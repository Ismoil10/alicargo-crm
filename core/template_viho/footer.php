 <? if ($_SESSION['user']['id'] != NULL) {
      require 'copyright.php';
   } ?>


 <script src="<?= $template_path ?>/assets/js/select2/select2.full.min.js"></script>


 <?/* <script src="<?=$template_path?>assets/js/jquery-3.5.1.min.js"></script> */ ?>
 <!-- feather icon js-->
 <script src="<?= $template_path ?>assets/js/icons/feather-icon/feather.min.js"></script>
 <script src="<?= $template_path ?>assets/js/icons/feather-icon/feather-icon.js"></script>
 <!-- Sidebar jquery-->
 <script src="<?= $template_path ?>assets/js/sidebar-menu.js"></script>
 <script src="<?= $template_path ?>assets/js/config.js"></script>
 <!-- Bootstrap js-->
 <script src="<?= $template_path ?>assets/js/bootstrap/popper.min.js"></script>
 <script src="<?= $template_path ?>assets/js/bootstrap/bootstrap.min.js"></script>
 <!-- Plugins JS start-->
 <script src="<?= $template_path ?>assets/js/chart/chartist/chartist.js"></script>
 <script src="<?= $template_path ?>assets/js/chart/chartist/chartist-plugin-tooltip.js"></script>
 <script src="<?= $template_path ?>assets/js/chart/knob/knob.min.js"></script>
 <script src="<?= $template_path ?>assets/js/chart/knob/knob-chart.js"></script>
 <script src="<?= $template_path ?>assets/js/chart/apex-chart/apex-chart.js"></script>
 <script src="<?= $template_path ?>assets/js/chart/apex-chart/stock-prices.js"></script>
 <script src="<?= $template_path ?>assets/js/prism/prism.min.js"></script>
 <script src="<?= $template_path ?>assets/js/clipboard/clipboard.min.js"></script>
 <script src="<?= $template_path ?>assets/js/counter/jquery.waypoints.min.js"></script>
 <script src="<?= $template_path ?>assets/js/counter/jquery.counterup.min.js"></script>
 <script src="<?= $template_path ?>assets/js/counter/counter-custom.js"></script>
 <script src="<?= $template_path ?>assets/js/custom-card/custom-card.js"></script>

 <!--<script src="<?= $template_path ?>/assets/js/select2/select2-custom.js"></script>-->

 <!--
    <script src="<?= $template_path ?>assets/js/notify/bootstrap-notify.min.js"></script>-->
 <script src="<?= $template_path ?>assets/js/vector-map/jquery-jvectormap-2.0.2.min.js"></script>
 <script src="<?= $template_path ?>assets/js/vector-map/map/jquery-jvectormap-world-mill-en.js"></script>
 <script src="<?= $template_path ?>assets/js/vector-map/map/jquery-jvectormap-us-aea-en.js"></script>
 <script src="<?= $template_path ?>assets/js/vector-map/map/jquery-jvectormap-uk-mill-en.js"></script>
 <script src="<?= $template_path ?>assets/js/vector-map/map/jquery-jvectormap-au-mill.js"></script>
 <script src="<?= $template_path ?>assets/js/vector-map/map/jquery-jvectormap-chicago-mill-en.js"></script>
 <script src="<?= $template_path ?>assets/js/vector-map/map/jquery-jvectormap-in-mill.js"></script>
 <script src="<?= $template_path ?>assets/js/vector-map/map/jquery-jvectormap-asia-mill.js"></script>
 <script src="<?= $template_path ?>assets/js/dashboard/default.js"></script>
 <script src="<?= $template_path ?>assets/js/notify/index.js"></script>
 <script src="<?= $template_path ?>assets/js/datepicker/date-picker/datepicker.js"></script>
 <script src="<?= $template_path ?>assets/js/datepicker/date-picker/datepicker.en.js"></script>
 <script src="<?= $template_path ?>assets/js/datepicker/date-picker/datepicker.custom.js"></script>
 <script src="<?= $template_path ?>assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
 <script src="<?= $template_path ?>assets/js/datatable/datatables/datatable.custom.js"></script>
 <script src="//cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.1/js/lightbox.min.js"></script>
 <!-- Plugins JS Ends-->
 <!-- Theme js-->
 <script src="<?= $template_path ?>assets/js/script.js"></script>
 <!--
    <script src="<?= $template_path ?>assets/js/theme-customizer/customizer.js"></script>
    -->
 <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
 <script>
    flatpickr("#date-range-input", {
       mode: "range",
       dateFormat: "Y/m/d",
       onClose: function(selectedDates, dateStr, instance) {
          const formatDate = (date) => date.toLocaleDateString('en-CA');

          if (selectedDates.length === 4) {

             const formattedRanges = `${formatDate(selectedDates[0])} to ${formatDate(selectedDates[1])}, ${formatDate(selectedDates[2])} to ${formatDate(selectedDates[3])}`;
             instance.input.value = formattedRanges;
          } else if (selectedDates.length === 2) {

             const formattedRange = `${formatDate(selectedDates[0])} to ${formatDate(selectedDates[1])}`;
             instance.input.value = formattedRange;
          }
       }
    });
 </script>
 <!-- login js-->
 <!-- Plugin used-->
 </body>

 </html>