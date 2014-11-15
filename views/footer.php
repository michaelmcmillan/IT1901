
    <script src="<?php echo $url; ?>/assets/js/jquery.min.js"></script>
    <script src="<?php echo $url; ?>/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo $url; ?>/assets/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo $url; ?>/assets/js/bootstrap-datepicker.nb.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.17"></script>
    <script src="<?php echo $url; ?>/assets/js/gmaps.js"></script>
    <script src="<?php echo $url; ?>/assets/js/sweet-alert.min.js"></script>
    <script src="<?php echo $url; ?>/assets/js/markerwithlabel.js"></script>
    <?php if ($user == true): ?>
    <script src="<?php echo $url; ?>/assets/js/user.js"></script>
    <?php endif; ?>
    <?php if ($admin == true): ?>
	<script src="<?php echo $url; ?>/assets/js/d3.v3.min.js" charset="utf-8"></script>
    <script src="<?php echo $url; ?>/assets/js/stats.js" charset="utf-8"></script>
	<script src="<?php echo $url; ?>/assets/js/admin.js"></script>
    <?php endif; ?>
  </body>
</html>
