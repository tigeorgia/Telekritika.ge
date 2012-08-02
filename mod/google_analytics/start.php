<?php
 
    function google_analytics_init()
    {
	// Extend the current footer to have the extended details
	elgg_extend_view('page/elements/footer', 'google_analytics/footer_extended');
    }
 
    register_elgg_event_handler('init','system','google_analytics_init');
 
?>