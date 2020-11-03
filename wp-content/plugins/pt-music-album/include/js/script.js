 jQuery(document).ready(function($){

	'use strict';
	var metaImageFrame;
	jQuery( 'body' ).click(function(e) {
		var btn = e.target;
		if ( !btn || !jQuery( btn ).attr( 'data-media-uploader-target' ) ) return;
		var field = jQuery( btn ).next();
		e.preventDefault();
		metaImageFrame = wp.media.frames.metaImageFrame = wp.media({
			title: meta_image.title,
			button: { text:  'Use this file' },
		});
		metaImageFrame.on('select', function() {
			var media_attachment = metaImageFrame.state().get('selection').first().toJSON();
			jQuery( field ).val(media_attachment.url);
		});
		metaImageFrame.open();
	});

	function uniqid(a = "",b = false){
	    var c = Date.now()/1000;
	    var d = c.toString(16).split(".").join("");
	    while(d.length < 14){
	        d += "0";
	    }
	    var e = "";
	    if(b){
	        e = ".";
	        var f = Math.round(Math.random()*100000000);
	        e += f;
	    }
	    return a + d + e;
	}

	jQuery('body').on('click', '.pt-admin-accordion .top .label', function() {
		if(jQuery(this).hasClass('active')) {
			jQuery(this).removeClass('active').parents('.pt-admin-accordion').find('.wrap').slideUp();
		} else {
			jQuery(this).addClass('active').parents('.pt-admin-accordion').find('.wrap').slideDown();
		}
	}).on('click', '.pt-admin-accordion .top .add', function() {
		var id = uniqid();
		var form_code = '<div class="pt-admin-accordion" style="display: none;">'+
			'<div class="top">'+
				'<div class="label active">Add Track</div>'+
				'<div class="remove fa fa-times" title="Remove item"></div>'+
				'<div class="add fa fa-plus" title="Add item"></div>'+
			'</div>'+
			'<div class="wrap" style="display: block;">'+
				'<input type="hidden" name="tracks['+id+'][id]" value="'+id+'">'+
				'<div class="input-row upload">'+
					'<button type="button" class="button" data-media-uploader-target="#pt_music_album_media">Upload Media</button>'+
					'<input type="url" class="upload-input" name="tracks['+id+'][track_url]" value="">'+
				'</div>'+
				'<div class="input-row">'+
					'<label>Name</label>'+
					'<div class="input"><input type="text" name="tracks['+id+'][name]" value=""></div>'+
				'</div>'+
				'<div class="input-row">'+
					'<label>Spotify</label>'+
					'<div class="input"><input type="url" name="tracks['+id+'][spotify]" value=""></div>'+
				'</div>'+
				'<div class="input-row">'+
					'<label>SoundCloud</label>'+
					'<div class="input"><input type="url" name="tracks['+id+'][soundcloud]" value=""></div>'+
				'</div>'+
				'<div class="input-row">'+
					'<label>Apple Music</label>'+
					'<div class="input"><input type="url" name="tracks['+id+'][apple_music]" value=""></div>'+
				'</div>'+
				'<div class="input-row">'+
					'<label>Google Play</label>'+
					'<div class="input"><input type="url" name="tracks['+id+'][google_play]" value=""></div>'+
				'</div>'+
			'</div>'+
		'</div>';

		jQuery(this).parents('.pt-admin-accordion').after(form_code).next().slideDown();
	}).on('click', '.pt-admin-accordion .top .remove', function() {
		jQuery(this).parents('.pt-admin-accordion').slideUp(function() {
			jQuery(this).remove();
		});
	});

});