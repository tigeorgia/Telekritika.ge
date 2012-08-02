<!-- Get the Google Analytics ID and insert in the extended Footer. -->

<?php
	$analyticsID = elgg_get_plugin_setting('analytics', 'google_analytics');
?>

<script type="text/javascript">
	var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
	document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>

<script type="text/javascript">
try {
	var pageTracker = _gat._getTracker("<?php echo $analyticsID; ?>");
	pageTracker._trackPageview();
} catch(err) {}
</script>
