<?php
/**
 * Save draft through ajax
 *
 * @package Segment
 */
?>
elgg.provide('elgg.segment');

/*
 * Attempt to save and update the input with the guid.
 */
elgg.segment.saveDraftCallback = function(data, textStatus, XHR) {
	if (textStatus == 'success' && data.success == true) {
		var form = $('form[name=segment_post]');

		// update the guid input element for new posts that now have a guid
		form.find('input[name=guid]').val(data.guid);

		oldDescription = form.find('textarea[name=description]').val();

		var d = new Date();
		var mins = d.getMinutes() + '';
		if (mins.length == 1) {
			mins = '0' + mins;
		}
		$(".segment-save-status-time").html(d.toLocaleDateString() + " @ " + d.getHours() + ":" + mins);
	} else {
		$(".segment-save-status-time").html(elgg.echo('error'));
	}
}

elgg.segment.saveDraft = function() {
	if (typeof(tinyMCE) != 'undefined') {
		tinyMCE.triggerSave();
	}

	// only save on changed content
	var form = $('form[name=segment_post]');
	var description = form.find('textarea[name=description]').val();
	var title = form.find('input[name=title]').val();

	if (!(description && title) || (description == oldDescription)) {
		return false;
	}

	var draftURL = elgg.config.wwwroot + "action/segment/auto_save_revision";
	var postData = form.serializeArray();

	// force draft status
	$(postData).each(function(i, e) {
		if (e.name == 'status') {
			e.value = 'draft';
		}
	});

	$.post(draftURL, postData, elgg.segment.saveDraftCallback, 'json');
}

elgg.segment.init = function() {
	// get a copy of the body to compare for auto save
	oldDescription = $('form[name=segment_post]').find('textarea[name=description]').val();
	
	setInterval(elgg.segment.saveDraft, 60000);

    $('.elgg-tagcloud a').click(function(e){
        e.preventDefault();
        var self = $(this);
        var field_id = self.parent().data('tagtype');
        var original = $('#'+field_id);
        var original_val = original.val();
        var newval = self.text();
        var between = "";
        if(original_val){between = ", "};
        $('#'+field_id).val(original_val+between+newval);

        var container = $('html');

        original.focus();

        container.animate({
            scrollTop: original.offset().top - container.offset().top
        });

        
    });

    jQuery(document).ready(function(){
       jQuery('.elgg-input-date').not('.cv_datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        maxDate: -1,
        });
    });
        
};

elgg.register_hook_handler('init', 'system', elgg.segment.init);