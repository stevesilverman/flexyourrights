var attachments_button_label_updater=null;
var attachments_button_label='Attach File';
var attachments_asset=null;
var attachments_metabox_id='';
var attachments_upload_handler=false;
var attachments_hijacked_thickbox=false;


function handle_content_update_file(title,caption,content,link,id,thumb) {

	var html = '';
	var regex_image = /(^.*\.jpg|jpeg|png|gif|ico*)/gi;
	//var regex_document = /(^.*\.pdf|doc|docx|ppt|pptx|odt|psd|eps|ai*)/gi;
	//var regex_audio = /(^.*\.mp3|m4a|ogg|wav*)/gi;
	//var regex_video = /(^.*\.mp4|m4v|mov|wmv|avi|mpg|ogv|3gp|3g2*)/gi;
	
	if (link.match(regex_image)) {
		html += '<div class="img_status">';
		html += '<a href="'+link+'"><img src="'+thumb+'" /></a>';
		html += '<a href="javascript:void(0);" class="remove_file_button" rel="'+id+'">Remove Image</a>';
		html += '</div>';
	}
	else {
		html += '<div class="no_image"><span class="file_link">';
		html += '<a href="'+link+'" target="_blank" rel="external">View File</a>'
		html += '</span>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" class="remove_file_button" rel="'+id+'">Remove</a></div>';
	}

	jQuery('#'+attachments_metabox_id, top.document).val(link);
	jQuery('#'+attachments_metabox_id+'_status', top.document)
		.html(html)
		.slideDown();

	tb_remove();
}



function handle_content_update_image(title,caption,content,link,id,thumb) {

	var html = '';
	
	html += '<li id="item_'+id+'" class="soil-multirow">';
	html += '	<a href="'+link+'"><img src="'+thumb+'" /></a>';
	//html += '	<a title="Delete this image" class="soil-delete-file" href="javascript:void(0);" rel="{{rel}}">Delete</a>';
	html += '	<input type="hidden" class="'+attachments_metabox_id+'" name="'+attachments_metabox_id+'[]" value="'+id+'" />';
	html += '</li>';
	
	var $banners_list = jQuery('#'+attachments_metabox_id+'-list',top.document);
	$banners_list.append(html);
	if($banners_list.length > 0) { 
		$banners_list.show();
	}
	
	reindexMultiBoxes($banners_list);
}


function handle_content_update_banner(title,caption,content,link,id,thumb) {
	attachment_index=jQuery('li.attachments-file',top.document).length;
	new_attachments='';
	
	attachment_name			= title;
	attachment_caption		= caption;
	attachment_content 		= content;
	attachment_link 		= link;
	attachment_id			= id;
	attachment_thumb		= thumb;
	
	new_attachments += '<li class="attachments-file soil-multirow">';
	
	// Handle / Image Title / Delete
	new_attachments += '<h2><a href="javascript:void(0);" class="soil-sortable-handle attachment-handle"><span class="attachment-handle-icon"><img src="' + attachments_base + '/img/handle.gif" alt="Drag" /></span></a><span class="attachment-name">' + attachment_name + '</span><span class="attachment-delete"><a href="javascript:void(0);">Delete</a></span></h2>';
		
	new_attachments += '<div class="attachments-fields">';
		
	// Title
	new_attachments += '<div class="textfield" id="field_'+attachments_metabox_id+'_title_' + attachment_index + '"><label for="'+attachments_metabox_id+'_title_' + attachment_index + '">Title</label><input class="soil-multiple" type="text" id="'+attachments_metabox_id+'_title_' + attachment_index + '" name="'+attachments_metabox_id+'[' + attachment_index + '][title]" value="' + attachment_name + '" size="20" /></div>';
	
	// Caption
	new_attachments += '<div class="textfield" id="field_'+attachments_metabox_id+'_caption_' + attachment_index + '"><label for="'+attachments_metabox_id+'_caption_' + attachment_index + '">Caption</label><input class="soil-multiple" type="text" id="'+attachments_metabox_id+'_caption_' + attachment_index + '" name="'+attachments_metabox_id+'[' + attachment_index + '][caption]" value="' + attachment_caption + '" size="20" /></div>';
	
	// Content
	new_attachments += '	<div class="textfield" id="field_'+attachments_metabox_id+'_content_' + attachment_index + '"><label for="'+attachments_metabox_id+'_content_' + attachment_index + '">Content</label><textarea class="soil-multiple" id="'+attachments_metabox_id+'_content_' + attachment_index + '" name="'+attachments_metabox_id+'[' + attachment_index + '][content]">' + attachment_content + '</textarea></div>';
	
	// Links
	new_attachments += '	<div class="textfield" id="field_'+attachments_metabox_id+'_link_' + attachment_index + '"><label for="'+attachments_metabox_id+'_link_' + attachment_index + '">Link</label><input class="soil-multiple" type="text" id="'+attachments_metabox_id+'_link_' + attachment_index + '" name="'+attachments_metabox_id+'[' + attachment_index + '][link]" value="' + attachment_link + '" size="20" /></div>';
	

	new_attachments += '</div>';
	
	// Hidden Inputs
	new_attachments += '<div class="attachments-data">';
		new_attachments += '<input class="soil-multiple" type="hidden" name="'+attachments_metabox_id+'[' + attachment_index + '][id]" id="'+attachments_metabox_id+'_id_' + attachment_index + '" value="' + attachment_id + '" />';
	new_attachments += '</div>';
	
	// Thumbnail
	new_attachments += '<div class="attachment-thumbnail">';
		new_attachments += '<img src="' + attachment_thumb + '" alt="Thumbnail" />';
	new_attachments += '</div>';

	new_attachments += '</li>';
	
	var $banners_list = jQuery('div#'+attachments_metabox_id+'-list',top.document);
	var $banners_ul = $banners_list.children('ul');
	
	$banners_ul.append(new_attachments);
	if($banners_ul.children('li').length>0) {
		$banners_list.show();
	}
	
	reindexMultiBoxes($banners_list);
}

jQuery(document).ready(function() {
	
	if(typeof send_to_editor==='function') {
		var attachments_send_to_editor_default=send_to_editor;
		send_to_editor=function(markup) {
			clearInterval(attachments_button_label_updater);
			if(attachments_hijacked_thickbox) {
				attachments_hijacked_thickbox=false;
			} else {
				attachments_send_to_editor_default(markup);
			}
		}
	}
	
	function attachments_update_button_label() {
	
		if(attachments_hijacked_thickbox) {
		
			jQuery('#TB_iframeContent').contents().find('td.savesend input').unbind('click').click(function(e) {
				
				theparent=jQuery(this).parent().parent().parent();
				jQuery(this).after('<span class="attachments-attached">Attached!</span>');
				thetitle=theparent.find('tr.post_title td.field input').val();
				thecaption=theparent.find('tr.post_excerpt td.field input').val();

				thedescription = theparent.find('tr.post_content td.field textarea').val();
				thelink = theparent.find('tr.url td.field input').val();

				theid=theparent.find('td.imgedit-response').attr('id').replace('imgedit-response-','');
				thethumb=theparent.parent().parent().find('img.pinkynail').attr('src');
				
				var update_fn = window[attachments_upload_handler];
				if(update_fn && typeof update_fn == 'function')
					update_fn(thetitle,thecaption,thedescription,thelink,theid,thethumb);
				
				theparent.find('span.attachments-attached').delay(1000).fadeOut('fast');
				return false;
				
			});
		if(jQuery('#TB_iframeContent').contents().find('.media-item .savesend input[type=submit], #insertonlybutton').length) {
			jQuery('#TB_iframeContent').contents().find('.media-item .savesend input[type=submit], #insertonlybutton').val(attachments_button_label);
		}
		if(jQuery('#TB_iframeContent').contents().find('#tab-type_url').length) {
			jQuery('#TB_iframeContent').contents().find('#tab-type_url').hide();
		}
		if(jQuery('#TB_iframeContent').contents().find('tr.post_title').length) {
			jQuery('#TB_iframeContent').contents().find('tr.image-size input[value="full"]').prop('checked',true);
			jQuery('#TB_iframeContent').contents().find('tr.post_title,tr.image_alt,tr.post_excerpt,tr.image-size,tr.post_content,tr.url,tr.align,tr.submit>td>a.del-link').hide();
		}}
		if(jQuery('#TB_iframeContent').contents().length==0&&attachments_hijacked_thickbox) {
			clearInterval(attachments_button_label_updater);
			attachments_hijacked_thickbox=false;
		}
	}
	
	jQuery('.soil-upload-button').live('click',function(event){
		var $button = jQuery(this),
			href=jQuery(this).attr('href'),
			width=jQuery(window).width(),
			H=jQuery(window).height(),
			W=(720<width)?720:width;

		if(!href) return true;
		href=href.replace(/&width=[0-9]+/g,'');
		href=href.replace(/&height=[0-9]+/g,'');

		$button.attr('href', href+'&width='+(W-80)+'&height='+(H-85));
		attachments_hijacked_thickbox = true;
		attachments_metabox_id = $button.attr("metabox_id");
		attachments_upload_handler = $button.attr("upload_handler");
		attachments_button_label_updater = setInterval(attachments_update_button_label,500);
		tb_show('Attach a file',event.target.href,false);
		return false;
	});

	jQuery('div.banner-list').each(function(n, el)
	{
		var $banner_list = jQuery(this);
		if($banner_list.find('li').length==0)
			$banner_list.hide();
	});
	
	jQuery('span.attachment-delete a').live('click',function() {
		var $attachment_parent = jQuery(this).parents(".attachments-file");
		var $attachment_list = $attachment_parent.parents(".banner-list");
		var $metabox = $attachment_list.parents(".soil-metabox");
		
		$attachment_parent.slideUp(function() {
			$attachment_parent.remove();
			if($attachment_list.find('li').length==0) {
				$attachment_list.slideUp(function() {
					$attachment_list.hide();
				});
			}

			else reindexMultiBoxes($metabox);
		});
		
		return false;
	});

});