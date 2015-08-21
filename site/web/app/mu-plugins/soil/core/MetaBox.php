<?php
// Prevent loading this file directly - Busted!
if( ! class_exists('WP') ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

/*
Script Name: 	BRL - Custom Metaboxes and Fields
Contributors: 	Nathan Smith (@alkymst / blueriotlabs.com)
				Luke Dennis (@lkfr / blueriotlabs.com)
				Ben Word (@retlehs / blueriotlabs.com)

Inspiration: 	Custom Metaboxes and Fields
By:				Andrew Norcross (@norcross / andrewnorcross.com)
				Jared Atchison (@jaredatch / jaredatchison.com)
				Bill Erickson (@billerickson / billerickson.net)
Description: 	This will create metaboxes with custom fields that will blow your mind and work without errors, and make more extendable.
Version: 		0.5
*/


if(!class_exists('soilMetaBox')) {

	class soilMetaBox {

		protected $_meta_box;
		protected $_fields;
		protected $_base_url;

		/** Create meta box based on given data */
		function __construct($meta_box) {

			// run script only in admin area
			if (!is_admin()) return;

			$this->_base_url = $this->build_base_url();

			// assign meta box values to local variables and add it's missed values
			$this->_meta_box = $meta_box;
			$this->_fields = &$this->_meta_box['fields'];
			$this->add_missed_values();

			add_action( 'add_meta_boxes', array(&$this, 'add') );
			add_action( 'save_post', array(&$this, 'save') );

			// check for some special fields and add needed actions for them
			$this->check_field_upload();
			$this->check_field_wysiwyg();
			$this->check_field_tabs();
			$this->check_field_colorpicker();


			// load common js, css files
			// must enqueue for all pages as we need js for the media upload, too
			add_action('admin_print_styles', array(&$this, 'admin_css'));
			add_action('admin_print_scripts', array(&$this, 'admin_js'));

			// load filter so show meatboxes on
			add_filter( 'cmb_show_on', array( &$this, 'add_for_id' ), 10, 2 );
			add_filter( 'cmb_show_on', array( &$this, 'add_for_page_template' ), 10, 2 );

		}


		/** Load common css files for the script */
		static function admin_css() {
			wp_enqueue_style( 'brl-meta-box-css', SOIL_CSS . '/meta-box.css' );
		}

		/** Load common js files for the script */
		static function admin_js() {
			wp_enqueue_script( 'brl-meta-box',  SOIL_JS . '/meta-box.js', array( 'jquery','jquery-ui-core', 'jquery-ui-sortable', 'media-upload','thickbox' ), null, true );
	  	}


		/******************** BEGIN GET FIELD NAME AND ID  **********************/

		function get_field_name($field, $post_id) {
			#$name = $field['id'] . (($field['multiple'] || $field['type'] === 'taxonomy') ? "[]" : "");
			$name = $field['id'] . (($field['type'] === 'taxonomy') ? "[]" : "");
			return $name;
		}

		function get_field_id($field, $post_id) {
			return $field['id'];
		}

		/******************** END GET FIELD NAME AND ID **********************/


		/******************** BEGIN UPLOAD **********************/

		/** Check field upload and add needed actions */
		function check_field_upload() {
			if ( $this->has_field('image') || $this->has_field('file') || $this->has_field('multi_file') || $this->has_field('file_list') || $this->has_field('banner') ) {

				// add data encoding type for file uploading
				add_action('post_edit_form_tag', array(&$this, 'add_enctype'));

				// add custom js for images
				wp_enqueue_script( 'brl-attachments', $this->_base_url . '/js/meta-attachments.js', array( 'brl-meta-box' ), null, true );

				// make upload feature works even when custom post type doesn't support 'editor'
				wp_enqueue_script('media-upload');
				add_thickbox();

				// todo - remove - use the new method of passing data between js and php
				add_action( 'admin_print_footer_scripts', array(&$this, 'attachments_header_js') );

				if($this->has_field('image')) {
					add_action('wp_ajax_rw_delete_file', array(&$this, 'delete_file'));			// ajax delete files
					add_action('wp_ajax_rw_reorder_images', array(&$this, 'reorder_images'));	// ajax reorder images
				}

			}

		}


		/** Ajax callback for deleting files. Modified from a function used by "Verve Meta Boxes" plugin (http://goo.gl/LzYSq) */
		function delete_file() {
			if (!isset($_POST['data'])) die();

			list($nonce, $post_id, $key, $attach_id) = explode('|', $_POST['data']);
			if (!wp_verify_nonce($nonce, 'rw_ajax_delete')) die('1');

			$new = array();
			$old = get_post_meta($post_id, $key, true);

			foreach ($old as $n) {
				if($attach_id != $n)
					$new[] = $n;
			}

			update_post_meta( $post_id, $key, $new, $old );
			die('0');
		}

		/** Ajax callback for reordering images */
		function reorder_images() {
			if (!isset($_POST['data'])) die();

			list($order, $post_id, $key, $nonce) = explode('|',$_POST['data']);
			if (!wp_verify_nonce($nonce, 'rw_ajax_reorder')) die('1');

			$old = get_post_meta($post_id, $key, true);
			$new_order = explode('&', str_replace('item[]=', '', $order));

			update_post_meta($post_id, $key, $new_order, $old);
			die('0');
		}


		/** Add data encoding type for file uploading */
		function add_enctype() {
			echo ' enctype="multipart/form-data"';
		}


		function attachments_header_js() {
			// only load on admin / edit pages
			if (!self::is_edit_page()) return;

		    echo '<script type="text/javascript" charset="utf-8">';
		    echo '  var attachments_base = "' . $this->_base_url . '"; ';
		    echo '  var attachments_media = ""; ';
		    echo '</script>';

		}


		/******************** END UPLOAD **********************/


		/******************** BEGIN OTHER FIELDS **********************/

		/** Check field WYSIWYG */
		function check_field_wysiwyg() {
			global $wp_version;

			if ($this->has_field('wysiwyg') && self::is_edit_page()) {

				if ( version_compare( $wp_version, '3.4.1'  /**  3.2.1 - TODO - Look into bug with 3.3 WYSISYGs */ ) < 1 ) {

					add_action( 'admin_print_footer_scripts', array(&$this, 'add_editor_footer_scripts'), 99 );

			 	 	wp_enqueue_script( 'brl_editor_init', SOIL_JS . '/brl.editor.js', 'tiny_mce', null, true );

					wp_enqueue_script( 'word-count' );
					wp_enqueue_script( 'post' );
					wp_enqueue_script( 'editor' );
					add_editor_style();

				}

			}
		}

		function add_editor_footer_scripts() { ?>

			<script type="text/javascript">/* <![CDATA[ */
			jQuery(function($) {
				var i=1;
				$('.customEditor textarea').each(function(e) {
				var id = $(this).attr('id');
					if (!id) {
					id = 'customEditor-' + i++;
					$(this).attr('id',id);
				}

				if(!$(this).hasClass("tinyMCE")) {
					$(this).addClass("tinyMCE");
					tinyMCE.execCommand('mceAddControl', false, id);
				}

				});

			});
			/* ]]> */</script>

		<?php }


		/** Check field tabs */
		function check_field_tabs() {
			if($this->has_field('tabs') ) {
				add_action( 'admin_print_footer_scripts', array(&$this, 'add_tabs_editor_footer_scripts'), 105 );
			}

		}

		/** add js for the tabs wysiwyg */
		function add_tabs_editor_footer_scripts( ) { ?>

			<script type="text/javascript">/* <![CDATA[ */
			jQuery(function($) {
				var i=1;
				$('.customTabbedEditor textarea').each(function(e) {
				var id = $(this).attr('id');
					if (!id) {
					id = 'customTabbedEditor-' + i++;
					$(this).attr('id',id);
				}

				if(!$(this).hasClass("tinyMCE")) {
					$(this).addClass("tinyMCE");
					tinyMCE.execCommand('mceAddControl', false, id);
				}

				});

			});
			/* ]]> */</script>

		<?php

		}

		/** Check field color */
		function check_field_colorpicker() {
			if ($this->has_field('colorpicker') && self::is_edit_page()) {
				wp_enqueue_style('farbtastic');		// enqueue built-in script and style for color picker
				wp_enqueue_script('farbtastic');
			}
		}


		/******************** END OTHER FIELDS **********************/


		/******************** BEGIN META BOX PAGE **********************/

		/** Add metaboxes */
		function add() {

			foreach ( $this->_meta_box['pages'] as $page ) {
				if( apply_filters( 'cmb_show_on', true, $this->_meta_box ) )
					add_meta_box( $this->_meta_box['id'], $this->_meta_box['title'], array(&$this, 'show'), $page, $this->_meta_box['context'], $this->_meta_box['priority']);
			}

		}
		
		/******************** BEGIN SHOW ON FILTERS *******************/

		// Add for ID 
		function add_for_id( $display, $meta_box ) {
			if ( 'id' !== @$meta_box['show_on']['key'] )
				return $display;
		
			// If we're showing it based on ID, get the current ID					
			if( isset( $_GET['post'] ) ) $post_id = $_GET['post'];
			elseif( isset( $_POST['post_ID'] ) ) $post_id = $_POST['post_ID'];
			if( !isset( $post_id ) )
				return false;
			
			// If value isn't an array, turn it into one	
			$meta_box['show_on']['value'] = !is_array( $meta_box['show_on']['value'] ) ? array( $meta_box['show_on']['value'] ) : $meta_box['show_on']['value'];
			
			// If current page id is in the included array, display the metabox
		
			if ( in_array( $post_id, $meta_box['show_on']['value'] ) )
				return true;
			else
				return false;
		}
		
		// Add for Page Template
		function add_for_page_template( $display, $meta_box ) {
			if( 'page-template' !== @$meta_box['show_on']['key'] )
				return $display;
				
			// Get the current ID
			if( isset( $_GET['post'] ) ) $post_id = $_GET['post'];
			elseif( isset( $_POST['post_ID'] ) ) $post_id = $_POST['post_ID'];
			if( !( isset( $post_id ) || is_page() ) ) return false;
				
			// Get current template
			$current_template = get_post_meta( $post_id, '_wp_page_template', true );
			
			// If value isn't an array, turn it into one	
			$meta_box['show_on']['value'] = !is_array( $meta_box['show_on']['value'] ) ? array( $meta_box['show_on']['value'] ) : $meta_box['show_on']['value'];
		
			// See if there's a match
			if( in_array( $current_template, $meta_box['show_on']['value'] ) )
				return true;
			else
				return false;
		}


		/******************** END SHOW ON FILTERS *********************/
		

		/** Callback function to show fields in meta box */
		function show() {
			global $post;$meta='';

			wp_nonce_field(basename(__FILE__), 'wp_meta_box_nonce');
			echo '<table class="form-table cmb_metabox">';

			foreach ($this->_fields as $field) {

				if(!isset($field['id'])) $field['id'] = null; // catch for title section

				#$meta = get_post_meta($post->ID, $field['id'], !$field['multiple']);
				$meta = get_post_meta($post->ID, $field['id'], true);
				$meta = ($meta !== '') ? $meta : $field['std'];

				# For multidimensional arrays, we have to escape each sub-array individually to prevent the array from becoming a string by accident
				if(is_array($meta)){
					foreach($meta as $meta_k => $meta_v)
						$meta[$meta_k] = is_array($meta_v) ? array_map('esc_attr', $meta_v) : esc_attr($meta_v);
				} else $meta = esc_attr($meta);

				echo '<tr>';
					$this->show_field_begin($field, $meta);
					// call separated methods for displaying each type of field
					call_user_func(array(&$this, 'show_field_' . $field['type']), $field, $meta);
					$this->show_field_description($field, $meta);
					$this->show_field_end($field, $meta);
				echo '</tr>';
			}
			echo '</table>';


		}

		/******************** END META BOX PAGE **********************/



		/******************** BEGIN META BOX FIELDS **********************/

		/** Field Opening */
		function show_field_begin($field, $meta) {
			if ( $field['type'] == "title" ) {
				echo '<td colspan="2">';
			} else {
				if( $this->_meta_box['show_names'] == true ) {
					echo '<th class="brl-label" style="width:18%"><label for="'.$field['id'].'">'.$field['name'].'</label></th>'; }
				echo '<td id="metabox_wrap'.$field['id'].'" class="soil-metabox">';
			}
		}

		/** Field Description */
		function show_field_description($field, $meta) {
			echo html( 'span', array('class'=>'cmb_metabox_description'), $field['desc'] );
		}

		/** Field Closing */
		function show_field_end($field, $meta) {
			echo '</td>';
		}


		/** Title */
		function show_field_title($field, $meta) {
			echo html( 'h5', array('class'=>'cmb_metabox_title'), $field['name'] );
		}

		/** Normal Text */
		/** Default Small - class = cmb_text_small */
		/** Default Medium = cmb_text_medium  */
		function show_field_text($field, $meta) {
			$args = array( 'class'	=> 'cmb_text' );
			$input_args = $this->merge_input_values($field, $meta, $args);
			echo html( 'input', $input_args );
		}

		/** Time */
		function show_field_time($field, $meta) {
			$args = array(
				'class'	=> 'cmb_timepicker text_time',
				'rel'	=> $field['format'],
			);
			$input_args = $this->merge_input_values($field, $meta, $args);
			echo html( 'input', $input_args );
		}

		/** Date Picker */
		function show_field_date($field, $meta) {
			$args = array( 'class'	=> 'cmb_text_small cmb_datepicker' );
			$input_args = $this->merge_input_values($field, $meta, $args);
			echo html( 'input', $input_args );
		}

		/** Date-TimeStamp / Picker */
		function show_field_date_timestamp($field, $meta) {
			$args = array(
				'class'	=> 'cmb_text_small cmb_datepicker',
				'value' => $meta ? date( 'm\/d\/Y', $meta ) : $field['std'],
			);
			$input_args = $this->merge_input_values($field, $meta, $args);
			echo html( 'input', $input_args );
		}

		/** Money Field */
		function show_field_text_money($field, $meta) {
			$args = array( 'class'	=> 'cmb_text_money' );
			$input_args = $this->merge_input_values($field, $meta, $args);
			echo '$ ' . html( 'input', $input_args );
		}

		/** Text Area */
		/** Default Small - class = cmb_textarea_small / rows = 4 */
		function show_field_textarea($field, $meta) {
			$args = array(
				'class'	=> 'cmb_textarea',
				'cols'	=> '60',
				'rows'	=> '10',
				'style'	=> 'width:97%;',
			);
			$input_args = $this->merge_input_values($field, $meta, $args);
			echo html( 'textarea', $input_args, $meta ? $meta : $field['std'] );
		}

		//** Default Text Area Code */
		function show_field_textarea_code($field, $meta) {
			$args = array(
				'class'	=> 'cmb_textarea_code',
				'cols'	=> '60',
				'rows'	=> '10',
				'style'	=> 'width:97%;',
			);
			$input_args = $this->merge_input_values($field, $meta, $args);
			echo html( 'textarea', $input_args, $meta ? $meta : $field['std'] );
		}

		/** Basic Select */
		function show_field_select($field, $meta) {
			$html_parts='';
			$html_parts .= 	html( 'option', array( 'value'	=> ''), '--Please Select --' );
			foreach ($field['options'] as $option) {
				$args = array( 'value'	=> $option['value']);
				if ( $meta == $option['value'] )
					$args['selected'] = 'selected';
				$html_parts .= html( 'option', $args, $option['name'] );
			}
			$input_args = $this->merge_input_values($field, $meta, array('class'=>'cmb_select') );
			echo html( 'select', $input_args, $html_parts );
		}

		/** Radio */
		function show_field_radio($field, $meta) {
			$html_parts='';
			$field['options'] = $this->normalize_input_options($field['options']);
			foreach ($field['options'] as $option_index => $option) {
				$args = array(
					'id' => $field['id'].'_'.$option_index,
					'value'	=> $option['value'],
				);
				$args['id'] = $field['id'].'_'.$option_index;
				$input_args = $this->merge_input_values($field, $meta, $args, $option['value']);
				$html_label = html( 'label', array('for' => $input_args['id']), $option['name'] );
				$html_parts .= html( 'li', html( 'input', $input_args ), $html_label );
			}
			echo html( 'ul', array('class'=>'cmb_radio'), $html_parts );
		}

		/** Radio Inline */
		/** TODO: move this into the method 'show_field_radio()' */
		function show_field_radio_inline($field, $meta) {
			$html_parts='';
			$field['options'] = $this->normalize_input_options($field['options']);
			foreach ($field['options'] as $option_index => $option) {
				$args = array(
					'id' => $field['id'].'_'.$option_index,
					'value'	=> $option['value'],
				);
				$input_args = $this->merge_input_values($field, $meta, $args, $option['value']);
				$html_label = html( 'label', array('for' => $input_args['id']), $option['name'] );
				$html_parts .= html( 'li', array('class'=>'cmb_radio_inline_option'), html( 'input', $input_args ), $html_label );
			}
			echo html( 'ul', array('class'=>'cmb_radio_inline'), $html_parts );
		}

		/** Checkbox */
		function show_field_checkbox($field, $meta) {
			$args = array( 'class'	=> 'cmb_checkbox' );
			$input_args = $this->merge_input_values($field, $meta, $args);
			echo html( 'input', $input_args );
		}

		/** Checkbox List */
		function show_field_checkbox_list($field, $meta) {
			$html_parts='';
			if (!is_array($meta)) $meta = (array) $meta;
			$field['options'] = $this->normalize_input_options($field['options']);
			foreach ( $field['options'] as $option ) {
				$args = array(
					'name'	=> $field['id'] . '[]',
					'value'	=> $option['value'],
					'id' => $field['id'].'_'.$option['value'],
				);
				$input_args = $this->merge_input_values($field, $meta, $args, $option['value']);
				$html_parts .= html( 'li',
					html( 'input', $input_args ),
					html( 'label', array('for' => $input_args['id']), $option['name'] ) );
			}
			echo html( 'ul', array('class'=>'cmb_checkbox_list'), $html_parts );
		}

		/** Wysiwyg */
		function show_field_wysiwyg($field, $meta) {
			global $wp_version;

			$settings = array();

			$data =array();
			$data['id'] = $field['id'];
			$data['meta'] = $meta;

			if ( version_compare( $wp_version, '3.4.1'  /**  3.2.1 - TODO - Look into bug with 3.3 WYSISYGs */ ) < 1 ) {
				echo soil_mustache_render( 'wysiwyg.html', $data );
			} else {
				$editor_settings = wp_parse_args( $settings,  array(
					'wpautop' => false, // use wpautop?
					'media_buttons' => true, // show insert/upload button(s)
					'textarea_name' => $field['id'], // set the textarea name to something different, square brackets [] can be used here
					'tabindex' => '',
					'editor_css' => '', // intended for extra styles for both visual and HTML editors buttons, needs to include the <style> tags, can use "scoped".
					'editor_class' => 'brlEditor large-text', // add extra class(es) to the editor textarea
					'teeny' => false, // output the minimal editor config used in Press This
					'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
					'quicktags' => true // load Quicktags, can be used to pass settings directly to Quicktags using an array()
				) );

				wp_editor( $meta, $field['id'], $editor_settings );
			}

		}

		/** Multiple Text */
		function show_field_text_multiple($field, $meta, $post_id='') {
			$data=array();
			$id = $this->get_field_id($field, $post_id);
			$name = $this->get_field_name($field, $post_id);
			$size = (isset($field['length']) ? $field['length'] : '50" style="width:60%');

			if (!is_array($meta)) $meta = (array) $meta;
			else if(count($meta) < 1) $meta = array("");

			foreach ($meta as $k => $m) {

				$data['list-item'][] = array(
					'class' => "soil-text {$field['id']}",
					'name' => "{$name}[]",
					'id' => "{$id}_{$k}",
					'value' => $m,
					'size' => $size
				);

			}

			echo soil_mustache_render( 'multi-text.html', $data );

		}

		/** Images */
		function show_field_image($field, $meta, $post_id='') {
			global $post, $temp_ID;
			$data=array();
			if (!is_array($meta)) $meta = (array) $meta;
			$name = $this->get_field_name($field, $post_id);

			if(empty($post_id)) $post_id = get_the_ID();

			$nonce_delete = wp_create_nonce('rw_ajax_delete');
			$nonce_sort = wp_create_nonce('rw_ajax_reorder');

	        $media_upload_iframe_src = "media-upload.php?post_id=$temp_ID&TB_iframe=1";
	        $image_upload_iframe_src = apply_filters( 'image_upload_iframe_src', "$media_upload_iframe_src" );

			$data['value'] = "{$post_id}|{$field['id']}|$nonce_sort";
			$data['id'] = "{$field['id']}";
			$data['rel'] = "{$post_id}|{$field['id']}";
			$data['upload_iframe_src'] = $image_upload_iframe_src;
			$data['upload_handler'] = 'handle_content_update_image'; // specific js handler
			$data['metabox_type'] = $field['type']; // metabox type passed into js function

			if (!empty($meta)) {
				$images = $meta;
				foreach ($images as $image) {

					$src = wp_get_attachment_image_src($image,'thumbnail');
					$src = $src[0];
					$post_link = get_edit_post_link($image);

					$data['images'][] = array(
						'li_id' => "item_$image",
						'post_link' => "$post_link",
						'img_src' => $src,
						'rel' => "$nonce_delete|{$post_id}|{$name}|$image",
						'input_class' => $field['id'],
						'input_name' => "{$name}[]",
						'input_value' => $image,
					);
				}
			}

			echo soil_mustache_render( 'images.html', $data );

		}

		/** File */
		function show_field_file($field, $meta) {
			global $temp_ID;
			if(empty($post_id)) $post_id = get_the_ID();

	        $media_upload_iframe_src = "media-upload.php?post_id=$temp_ID&TB_iframe=1";
	        $image_upload_iframe_src = apply_filters( 'image_upload_iframe_src', "$media_upload_iframe_src" );

			$data=array();
			//$data['id'] = $field['id'];
			$data['id'] = "{$field['id']}";
			$data['meta'] = $field['std'];
			$data['rel'] = "{$post_id}|{$field['id']}";
			$data['upload_handler'] = 'handle_content_update_file'; // specific js handler
			$data['metabox_type'] = $field['type']; // metabox type passed into js function
			$data['upload_iframe_src'] = $image_upload_iframe_src; // metabox type passed into js function

			if ( $meta != '' ) {
				$data['meta'] = $meta;
				$check_image = preg_match( '/(^.*\.jpg|jpeg|png|gif|ico*)/i', $meta );
				if ( $check_image ) {
					$data['image'] = array(true);
				} else {
					$data['file'] = array(true);
					$parts = explode( "/", $meta );
					for( $i = 0; $i < sizeof( $parts ); ++$i ) {
						$title = $parts[$i];
					}
					$data['file_title'] = $title;
				}
			}

			echo soil_mustache_render( 'file.html', $data );

		}

		/** Multiple File */
		function show_field_multi_file($field, $meta) {
			global $post; $data=array();
			if (!is_array($meta)) $meta = (array) $meta;
			$data['id'] = "metabox_button{$field['id']}";
			$data['name'] = "{$field['id']}[]";
			$data['upload_handler'] = 'handle_content_update_multi_file'; // specific js handler
			$data['metabox_type'] = $field['type']; // metabox type passed into js function

			if (!empty($meta)) {
				$data['nonce'] = wp_create_nonce('rw_ajax_delete');
				$nonce = wp_create_nonce('rw_ajax_delete');

				foreach ($meta as $file) {
					$data['files'][] = array(
						'attach_link' =>  wp_get_attachment_link($file, '' , false, false, ' '),
						'delete_rel' => "$nonce|{$post->ID}|{$field['id']}|$file",
					);
				}
			}

			echo soil_mustache_render( 'multi-file.html', $data );

		}

		/** File List */
		function show_field_file_list($field, $meta) {
			global $post; $data=array();
			//$data['id'] = $field['id'];
			$data['id'] = "metabox_button{$field['id']}";
			$data['upload_handler'] = 'handle_content_file_list'; // specific js handler
			$data['metabox_type'] = $field['type']; // metabox type passed into js function

			$args = array(
				'post_type' => 'attachment',
				'numberposts' => null,
				'post_status' => null,
				'post_parent' => $post->ID
			);
			$attachments = get_posts($args);

			if ($attachments) {
				foreach ($attachments as $attachment) {
					$data['files'][] = array(
						'attach_link' =>  wp_get_attachment_link($attachment->ID, 'thumbnail', 0, 0, 'Download'),
						'attach_title' =>  apply_filters('the_title', '&nbsp;'.$attachment->post_title),
					);
				}
			}

			echo soil_mustache_render( 'file-list.html', $data );

		}

		/** Color Picker */
		function show_field_colorpicker($field, $meta) {
			if (empty($meta)) $meta = '#';
			$args = array(
				'class'	=> 'soil-color',
				'size'	=> '8;',
			);
			$input_args = $this->merge_input_values($field, $meta, $args);
			echo html( 'input', $input_args );
			echo html( 'a', array('href'=>'#','class'=>'soil-color-select','rel'=>$field['id'],'value'=>$meta), __('Select a color') );
			echo html( 'div', array('class'=>'soil-color-picker','rel'=>$field['id'],'style'=>'display:none') );
		}

		/** Taxonomy Select */
		function show_field_taxonomy_select($field, $meta) {
			global $post; $html_parts='';
			$names= wp_get_object_terms( $post->ID, $field['taxonomy'] );
			$terms = get_terms( $field['taxonomy'], 'hide_empty=0' );
			foreach ( $terms as $term ) {
				if (!is_wp_error( $names ) && !empty( $names ) && !strcmp( $term->slug, $names[0]->slug ) )
					$html_parts .= html( 'option', array('value'=>$term->slug,'selected'=>'selected'), $term->name );
				else
					$html_parts .= html( 'option', array('value'=>$term->slug), $term->name );
			}
			$input_args = $this->merge_input_values($field, $meta, array('class'=>'cmb_taxonomy_select') );
			echo html( 'select', $input_args, $html_parts );
		}

		/** Taxonomy Radio */
		function show_field_taxonomy_radio($field, $meta) {
			global $post; $html_parts='';
			$names= wp_get_object_terms( $post->ID, $field['taxonomy'] );
			$terms = get_terms( $field['taxonomy'], 'hide_empty=0' );
			foreach ( $terms as $term_index => $term ) {
				if ( !is_wp_error( $names ) && !empty( $names ) && !strcmp( $term->slug, $names[0]->slug ) )
					$args = array( 'value'	=> $term->slug, 'checked' => 'checked' );
				else $args = array( 'value'	=> $term->slug );
				$args['id'] = $field['id'].'_'.$term_index;

				$input_args = $this->merge_input_values($field, $meta, $args);
				$html_label = html('label', array('for' => $input_args['id']), $term->name);
				$html_parts .= html( 'li', html( 'input', $input_args ), $html_label);
			}
			echo html( 'ul', array('class'=>'cmb_taxonomy_radio'), $html_parts );
		}

		/** Template Select */
		function show_field_template($field, $meta) {
			$html_parts='';
			$template_label = $field['label'] ? $field['label'] : array( 'Template Name' );
			$templates = $this->get_post_templates(array( 'label' => $template_label ));
			$html_parts .= 	html( 'option', array( 'value'	=> ''), 'Default Template' );
			foreach ($templates as $option => $name) {
				$args = array( 'value'	=> $name);
				if ( $meta == $name )
					$args['selected'] = 'selected';
				$html_parts .= html( 'option', $args, $option );
			}
			$input_args = $this->merge_input_values($field, $meta, array('class'=>'cmb_select') );
			echo html( 'select', $input_args, $html_parts );
		}

		/** Menu Select */
		function show_field_menu($field, $meta) {
			$html_parts='';$sel_args = array();

			$nav_menus = wp_get_nav_menus( array('orderby' => 'name') );

			if ($meta == "none")
				$sel_args = array('selected'=>'selected');

			$html_parts .= html( 'option', array_merge(array('value'=>'none'),$sel_args), '-- none --' );

			foreach ( (array) $nav_menus as $key => $_nav_menu ) {
				$_nav_menu->truncated_name = trim( wp_html_excerpt( $_nav_menu->name, 40 ) );
				if ( $_nav_menu->truncated_name != $_nav_menu->name )
					$_nav_menu->truncated_name .= '&amp;hellip;';
				$nav_menus[$key]->truncated_name = $_nav_menu->truncated_name;

				$args = array( 'value'	=> esc_html( $_nav_menu->truncated_name ));
				if ( esc_html( $_nav_menu->truncated_name ) == $meta )
					$args['selected'] = 'selected';
				$html_parts .= html( 'option', $args, esc_html( $_nav_menu->truncated_name ) );
			}

			$input_args = $this->merge_input_values($field, $meta, array('class'=>'cmb_select') );
			echo html( 'select', $input_args, $html_parts );

		}

		/** FAQ's */
		function show_field_faq($field, $meta, $post_id='') {
			$data=array();
			$id = $this->get_field_id($field, $post_id);
			$name = $this->get_field_name($field, $post_id);
			$size = (isset($field['length']) ? $field['length'] : "30' style='width:50%");

			if (!is_array($meta)) $meta = (array) $meta;
			if(empty($meta) || @empty($meta[0])) $meta = array(array('q' => '', 'a' => ''));

			foreach ($meta as $k => $m) {
				if(!isset($m['q']) || !isset($m['a'])) continue;

				$data['faqs'][] = array(
					'q_class' => "soil-text soil-multi {$field['id']}_q",
					'q_name' => "{$name}[{$k}][q]",
					'q_id' => "{$id}_q_{$k}",
					'q_value' => $m['q'],
					'q_size' => $size,
					'a_name' => "{$name}[{$k}][a]",
					'a_id' => "{$id}_a_{$k}",
					'a_value' => $m['a']
				);

			}

			echo soil_mustache_render( 'faqs.html', $data );

		}

		/** Tabs */
		function show_field_tabs($field, $meta, $post_id='') {
			$data=array();
			$id = $this->get_field_id($field, $post_id);
			$name = $this->get_field_name($field, $post_id);
			$size = (isset($field['length']) ? $field['length'] : "30' style='width:50%");

			if (!is_array($meta)) $meta = (array) $meta;
			if(empty($meta) || @empty($meta[0])) $meta = array(array('title' => '', 'content' => ''));

			foreach ($meta as $k => $m) {
				if(!isset($m['title']) || !isset($m['content'])) continue;

				$data['tabs'][] = array(
					'tab_class' => "soil-text {$field['id']}_title",
					'tab_name' => "{$name}[{$k}][title]",
					'tab_id' => "{$id}_title_{$k}",
					'tab_value' => $m['title'],
					'tab_size' => $size,
					'content_name' => "{$name}[{$k}][content]",
					'content_id' => "{$id}_content_{$k}",
					'content_value' => $m['content']
				);

			}

			echo soil_mustache_render( 'tabs.html', $data );

		}

		/** Banner Manager - Draggable & Orderable */
		/** TODO: Turn into an array of inputs that will also need to modifiy the JS output. */
		/** TODO: Sort based on data order, not a field value */
		function show_field_banner($field, $meta) {
			global $temp_ID; $data=array();

	        $media_upload_iframe_src = "media-upload.php?post_id=$temp_ID&TB_iframe=1";
	        $image_upload_iframe_src = apply_filters( 'image_upload_iframe_src', "$media_upload_iframe_src" );

			$data['id'] = "{$field['id']}";
			$data['upload_iframe_src'] = $image_upload_iframe_src;
			$data['upload_handler'] = 'handle_content_update_banner'; // specific js handler
			$data['metabox_type'] = $field['type']; // metabox type passed into js function

			$attachments = array();
			if(!empty($meta)) foreach($meta as $k => $m) {
	            $attachment = $this->attachments_get_single_attachment( $m['id'] );
	            if(empty($attachment)) continue;

	            $attachments[] = array_merge($attachment, $m);
	        }

	        if(!empty($attachments)) foreach($attachments as $k => $attachment) {

				$data['attachments'][] = array(
					'sort_handle_src' => $this->_base_url .'/img/handle.gif',
					'attachment_count' => $k,
					'attachment_name' => isset($attachment['name']) ? $attachment['name'] : '',
					'attachment_title' => isset($attachment['title']) ? $attachment['title'] : '',
					'attachment_caption' => isset($attachment['caption']) ? $attachment['caption'] : '',
					'attachment_content' => isset($attachment['content']) ? $attachment['content'] : '',
					'attachment_link' => isset($attachment['link']) ? $attachment['link'] : '',
					'attachment_thumb' => isset($attachment['id'])
						? wp_get_attachment_image( $attachment['id'], array(90, 90), 1 ) : '',
					'attachment_id' => isset($attachment['id']) ? $attachment['id'] : '',

				//	'attachment_order' => $attachment['order'],
				);

			} # end foreach meta

			echo soil_mustache_render( 'banner.html', $data );

		}

		/** P2P Connection */
		function show_field_p2p($field, $meta) {
			$data = array();
			$size = (isset($field['length']) ? $field['length'] : "30' style='width:50%");

			if(!is_array($meta)) $meta = (array) $meta;
			if(empty($meta) || @empty($meta[0])) $meta = array(array('postid' => ''));

			$id = $data['id'] = "{$field['id']}";
			$name = $data['name'] = "{$field['name']}";
			$data['jsvar'] = "all_{$id}_posts";

			foreach ($meta as $k => $m) {
				if(!isset($m['postid'])) continue;

				$data['p2ps'][] = array(
					'title_class' => "soil-text {$id}_title",
					'title_name' => "{$id}[{$k}][title]", # note: field is ignored on save
					'title_id' => "{$id}_title_{$k}",
					'title_value' => empty($m['postid']) ? '' : get_the_title($m['postid']),
					'title_size' => $size,
					'postid_name' => "{$id}[{$k}][postid]",
					'postid_id' => "{$id}_postid_{$k}",
					'postid_value' => $m['postid']
				);

			}
			
			# Query for posts, optionally filtering by post type
			global $wpdb;
			$sql  = "SELECT `ID`, post_title FROM {$wpdb->prefix}posts WHERE ";
			$sql .= "post_type NOT IN ('revision', 'menu', 'attachment', 'nav_menu_item')";
			
			if(isset($field['args']['post_type']))
			{
				if(!is_array($field['args']['post_type']))
					$field['args']['post_type'] = array($field['args']['post_type']);
					
				$sql .= " AND post_type IN ('".implode("','", $field['args']['post_type'])."')";
			}
			
			$temp_posts = $wpdb->get_results($sql, ARRAY_A);
			
			$found_posts = array();
			if(!empty($temp_posts)) foreach($temp_posts as $p)
				$found_posts[$p['post_title']] = $p['ID'];
			
			echo soil_mustache_render('p2p.html', $data);
			
			echo html('script', array('type' => 'text/javascript'),
				"var {$data['jsvar']} = ".json_encode($found_posts).";"
			.	"var {$data['jsvar']}_keys = ".json_encode(array_keys($found_posts)).";"
			);
		}


		/** Url */
		function show_field_url($field, $meta, $post_id='') {			
			$html_parts = '';$list_items = '';
			$id = $this->get_field_id($field, $post_id);
			$name = $this->get_field_name($field, $post_id);
									
			if (!is_array($meta)) $meta = (array) $meta;
			if(empty($meta) || @empty($meta[0])) $meta = array(array('title' => '', 'url' => ''));

			foreach ($meta as $k => $m) {
				if(!isset($m['title']) || !isset($m['url'])) continue;

					// Title
					$html_parts .= html( 'label', array('for'=>"{$id}_title_{$k}"), __('Title:', '2995') );
					$html_parts .= html( 'input', array(
						'name' => "{$name}[{$k}][title]",
						'id' => "{$id}_title_{$k}",
						'value' => $m['title'],
						'class' => 'cmb_text_small cmb_text soil-multiple',
						'type' => 'text',
					));
					
					// Url
					$html_parts .= html( 'label', array('for'=>"{$id}_url_{$k}"), __('Url:','2995') );
					$html_parts .= html( 'input', array(
						'name' => "{$name}[{$k}][url]",
						'id' => "{$id}_url_{$k}",
						'value' => $m['url'],
						'class' => 'cmb_text_medium cmb_text soil-multiple',
						'type' => 'text',
					)); 
					
					// Delete			
					$html_parts .= html ( 'a', array( 'href' => 'javascript:void(0);', 'class' => 'button-secondary soil-multirow-delete' ), __('Delete','2995') );

					$list_items .= html( 'li', array( 'class' => 'soil-multirow' ), $html_parts );
					$html_parts = '';					
			}
			
			echo html ( 'ul', array( 'class' => 'soil-sortable' ), $list_items );
			echo html ( 'a', array( 'href' => 'javascript:void(0);', 'class' => 'button-primary soil-multirow-add' ), __('Add New Item','2995') ); 			
					
		}		
		

		/******************** END META BOX FIELDS **********************/


		/******************** BEGIN META BOX SAVE **********************/


		/** Save data from meta box */
		function save($post_id) {

			global $post_type;
			$post_type_object = get_post_type_object($post_type);

			if ((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)						// check autosave
			|| (!isset($_POST['post_ID']) || $post_id != $_POST['post_ID'])			// check revision
			|| (!in_array($post_type, $this->_meta_box['pages']))					// check if current post type is supported
			|| (!check_admin_referer(basename(__FILE__), 'wp_meta_box_nonce'))		// verify nonce
			|| (!current_user_can($post_type_object->cap->edit_post, $post_id))) {	// check permission
				return $post_id;
			}

			foreach ($this->_fields as $field) {

				// Titles don't need to be saved
				if($field['type'] == 'title') continue;

				$name = $field['id'];
				$type = $field['type'];
				$old = get_post_meta($post_id, $name, !$field['multiple']);
				$new = isset($_POST[$name]) ? $_POST[$name] : ($field['multiple'] ? array() : '');

				// validate meta value
				if (class_exists('Soil_Meta_Box_Validate') && method_exists('Soil_Meta_Box_Validate', $field['validate_func'])) {
					$new = call_user_func(array('Soil_Meta_Box_Validate', $field['validate_func']), $new);
				}

				// Validate via filter
				if(has_filter('soil_validate_field_'.$field['id'])) {
					$new = apply_filter('soil_validate_field_'.$field['id'], $new, $post_id);
				} elseif (has_filter('soil_validate_field')) {
					$new = apply_filter('soil_validate_field', $new, $post_id, $name);
				}

				// call defined method to save meta value, if there's no methods, call common one
				$save_func = 'save_field_' . $type;
				if (method_exists($this, $save_func)) {
					call_user_func(array(&$this, 'save_field_' . $type), $post_id, $field, $old, $new);
				} else {
					$this->save_field($post_id, $field, $old, $new);
				}
			}
		}


		/** Common functions for saving */
		function save_field($post_id, $field, $old, $new) {
			$name = $field['id'];

			$has_data = $new ? true : false;
			if ($has_data && $field['multiple']) {
				$no_data = true;

				if(!is_array($new)) $has_data = false;
				else foreach($new as $add_new) {
					if(!empty($add_new)) {
						$no_data = false;
						break;
					}
				}
				if($no_data) $has_data = false;
			}

			if ( $has_data && $new != $old ) {
				update_post_meta( $post_id, $name, $new );
			} elseif ( !$has_data && $field['type'] != 'file' ) {
				delete_post_meta( $post_id, $name );
			}

		}

		/** Save Textarea */
		function save_field_textarea($post_id, $field, $old, $new) {
			$new = htmlspecialchars( $new );
			$this->save_field($post_id, $field, $old, $new);
		}

		/** Save Textarea Code */
		function save_field_textarea_code($post_id, $field, $old, $new) {
			$new = htmlspecialchars_decode( $new );
			$this->save_field($post_id, $field, $old, $new);
		}

		/** Save Date Timestamp */
		function save_field_date_timestamp($post_id, $field, $old, $new) {
			$new = strtotime( $new );
			$this->save_field($post_id, $field, $old, $new);
		}

		/** Save WYSIWYG */
		function save_field_wysiwyg($post_id, $field, $old, $new) {
			$new = wpautop($new);
			$this->save_field($post_id, $field, $old, $new);
		}

		/** Save Color */
		function save_field_colorpicker($post_id, $field, $old, $new) {
			if($new == '#') $new = '';
			$this->save_field($post_id, $field, $old, $new);
		}

		/** Save Multicheck / Checkbox List */
		function save_field_checkbox_list($post_id, $field, $old, $new) {
			if ( !is_array($new) || empty($new) ) $new = array();
			$this->save_field($post_id, $field, $old, $new);

		}

		/** Save Taxonomy */
		function save_field_taxonomy_select($post_id, $field, $old, $new) {
			$new = wp_set_object_terms( $post_id, $new, $field['taxonomy'] );
		}
		function save_field_taxonomy_radio($post_id, $field, $old, $new) {
			$new = wp_set_object_terms( $post_id, $new, $field['taxonomy'] );
		}

		/** Save FAQ's */
		function save_field_faq($post_id, $field, $old, $new) {

			$has_data = false;
			if(is_array($new) && !empty($new))

			foreach($new as $faq) {
				if(!@empty($faq['q']) || !@empty($faq['a'])) {
					$has_data = true;
					break;
				}
			}

			if($has_data)
				$this->save_field($post_id, $field, $old, $new);
			else
				$this->save_field($post_id, $field, $old, "");
		}

		/** Save Tabs */
		function save_field_tabs($post_id, $field, $old, $new) {
			$has_data = false;

			if(is_array($new) && !empty($new))
			foreach($new as $faq) {
				if(!@empty($faq['title']) || !@empty($faq['content'])) {
					$has_data = true;
					break;
				}
			}

			if($has_data)
				$this->save_field($post_id, $field, $old, $new);
			else
				$this->save_field($post_id, $field, $old, "");
		}

		/** Save Field Muti File */
		function save_field_multi_file($post_id, $field, $old, $new) {
			$has_data = false;
			$new = array();

			if( is_array($old) && !empty($old) )
				$has_data = true;
			elseif ( !is_array($old) || empty($old) )
				$old = array();

			$name = $field['id'];
			if (empty($_FILES[$name])) return;

			$this->fix_file_array($_FILES[$name]);

			foreach ($_FILES[$name] as $position => $fileitem) {
				$file = wp_handle_upload($fileitem, array('test_form' => false));

				if (empty($file['file'])) continue;
				$filename = $file['file'];

				$attachment = array(
					'post_mime_type' => $file['type'],
					'guid' => $file['url'],
					'post_parent' => $post_id,
					'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
					'post_content' => ''
				);
				$id = wp_insert_attachment($attachment, $filename, $post_id);
				if (!is_wp_error($id)) {
					wp_update_attachment_metadata($id, wp_generate_attachment_metadata($id, $filename));
					$has_data = true;
					$new[] = $id;
				}
			}

			$new = wp_parse_args( $new, $old );

			if($has_data)
				$this->save_field($post_id, $field, $old, $new);
			else
				$this->save_field($post_id, $field, $old, '');
		}

		/** Save Banner */
		function save_field_banner($post_id, $field, $old, $new) {

			if(is_array($new) && !empty($new))
			foreach($new as $banner) {
				if(!@empty($banner['id'])) {
					$has_data = true;
					break;
				}
			}

			if($has_data)
				$this->save_field($post_id, $field, $old, $new);
			else
				$this->save_field($post_id, $field, $old, "");
		}
		
		
		function save_field_p2p($post_id, $field, $old, $new)
		{
			$save_array = array();
		
			if(is_array($new) && !empty($new))
			foreach($new as $p2p) {
				if(!@empty($p2p['postid'])) {
					$save_array[]['postid'] = $p2p['postid'];
				}
			}

			if(!empty($save_array))
				$this->save_field($post_id, $field, $old, $save_array);
			else
				$this->save_field($post_id, $field, $old, "");
		}


		/******************** END META BOX SAVE **********************/



		/******************** BEGIN HELPER FUNCTIONS **********************/


		/** Add missed values for meta box */
		function add_missed_values() {
			// default values for meta box
			$this->_meta_box = array_merge(array(
				'context' => 'normal',
				'priority' => 'high',
				'pages' => array('post')
			), $this->_meta_box);

			// default values for fields
			foreach ($this->_fields as &$field) {
				$multiple = in_array($field['type'], array('checkbox_list', 'multi_file', 'image', 'multicheck', 'banner', 'faq', 'text_multiple'));
				$std = $multiple ? array() : '';
				$format = 'date' == $field['type'] ? 'yy-mm-dd' : ('time' == $field['type'] ? 'hh:mm' : '');

				$field = array_merge(array(
					'multiple' => $multiple,
					'std' => $std,
					'desc' => '',
					'format' => $format,
					'validate_func' => ''
				), $field);
			}
		}

		/** Set the base URL to be used for images and assets */
		function build_base_url() {
			$base_url = SOIL_URI;
			return $base_url;
		}

		/** Check if field with $type exists */
		function has_field($type) {
			foreach ($this->_fields as $field) {
				if ($type == $field['type']) return true;
			}
			return false;
		}

		/** Check if current page is edit page */
		static function is_edit_page() {
			global $pagenow;
			return in_array($pagenow, array('post.php', 'post-new.php'));
		}

		/**
		 * Fixes the odd indexing of multiple file uploads from the format:
		 *	 $_FILES['field']['key']['index']
		 * To the more standard and appropriate:
		 *	 $_FILES['field']['index']['key']
		 */
		static function fix_file_array(&$files) {
			$output = array();
			foreach ($files as $key => $list) {
				foreach ($list as $index => $value) {
					$output[$index][$key] = $value;
				}
			}
			$files = $output;
		}

		/**
		 * Compares two array values with the same key "order"
		 *
		 * @param string $a First value
		 * @param string $b Second value
		 * @return int
		 */
		static function attachments_cmp($a, $b) {
			$a = intval( $a['order'] );
			$b = intval( $b['order'] );

			if( $a < $b ) return -1;
			else if( $a > $b ) return 1;
			else return 0;
		}


		/**
		 * Soil supports two ways of passing options via array:
		 *
		 *   array('input_name' => 'Input Value')
		 *     - OR -
		 *   array( array('name' => 'input_name', 'value' => 'Input Value') )
		 *
		 * This function converts the former to the latter, if necessary.
		**/
		function normalize_input_options($options)
		{
			if(!soil_is_assoc($options)) return $options;

			$new_options = array();
			foreach($options as $opt_key => $opt_val) {
				$new_options[] = array(
					'name' => $opt_key,
					'value' => $opt_val,
				);
			}
			return $new_options;
		}

		/**
		 * Retrieves all Attachments for provided Post or Page
		 *
		 * @param int $post_id (optional) ID of target Post or Page, otherwise pulls from global $post
		 * @return array $post_attachments
		**/
		function attachments_get_single_attachment( $attachment_post_id, $args = array() ) {

			// Define the array of defaults
			$defaults = array(
				'post_id' => $attachment_post_id,
				'size' => 'large',
			);

			// Parse incomming $args into an array and merge it with $defaults
			$args = wp_parse_args( $args, $defaults );

			// get all attachments
			$attachment = get_post_meta( $attachment_post_id, "_wp_attachment_metadata", true );

			$img_size = wp_get_attachment_image_src($attachment_post_id, $args['size']);

	        return array(
	            'id' 		=> stripslashes( $attachment_post_id ),
	            'name' 		=> stripslashes( get_the_title( $attachment_post_id ) ),
	            'mime' 		=> stripslashes( get_post_mime_type( $attachment_post_id ) ),
				'location' 	=> stripslashes( $img_size[0] ),
				'width' 	=> stripslashes( $img_size[1] ),
				'height' 	=> stripslashes( $img_size[2] ),
	        );
		}

		/**
		 * Merge input values with defaults
		 *
		 * @return array
		 */
		function merge_input_values( $field, $meta, $input_args, $option=null ) {

			$modified_args = array();

			// Define the array of defaults
			$defaults = array(
				'type' 	=> 'text',
				'name' 	=> $field['id'],
				'id' 	=> $field['id'],
				'value' => $meta ? $meta : $field['std'],
			);

			// if we have field args merge into the input array
			if ( isset($field['args']) ) {
				$field_args = $field['args'];
				$field_args['class'] = implode( ' ', wp_list_pluck( array($field['args'],$input_args), 'class' ) );
				$input_args = wp_parse_args( $field_args, $input_args );
			}

			 // Merge with new args with the defaults
			$args = wp_parse_args( $input_args, $defaults );

			// Textareas
			if ( in_array( $field['type'], array('textarea','textarea_small') ) ) {
				unset($args['type']);
				unset($args['value']);
			}

			// Convert associative options array to ordered array, if needed
			if(!@empty($field['options']) && !soil_is_assoc($field['options'])) {
				$field['options'] = $this->normalize_input_options($field['options']);
			}

			// Radio
			if ( in_array( $field['type'], array('radio','radio_inline','taxonomy_radio') ) ) {
				$modified_args['type'] = 'radio';
			}

			// Checkbox
			if ( in_array( $field['type'], array('checkbox','checkbox_list','multicheck') ) ) {
				$modified_args['type'] = 'checkbox';
				if ( in_array( $field['type'], array('checkbox') ) )
					unset($args['value']);
			}

			// Select
			if ( in_array( $field['type'], array('select','menu') ) ) {
				unset($args['type']);
			}

			// Check the active field
			if( $this->is_checked( $field, $meta, $option ) ) {
				if ( in_array( $field['type'], array('radio','radio_inline','checkbox','checkbox_list','multicheck') ) )
					$modified_args['checked'] = 'checked';
			}

			// combine the input args one more time
			return wp_parse_args( $modified_args, $args );

		}


		/**
		 * Check the input field to see if it should checked
		 *
		 * @return true/false
		 */
		function is_checked( $field, $meta, $option=null ) {

			$checked = false;

			// Radio
			if ( in_array( $field['type'], array('radio','radio_inline') ) ) {
				if( $meta == $option ) $checked = true;
			}

			// Checkbox
			if ( in_array( $field['type'], array('checkbox','checkbox_list','multicheck') ) ) {
				if ( in_array( $field['type'], array('checkbox_list','multicheck') ) ) {
					if( in_array( $option, $meta ) ) $checked = true;
				} elseif ( $field['type'] == 'checkbox' ) {
					if($meta) $checked = true;
				}

			}

			return $checked;

		}


		function get_post_templates( $args = array() ) {

			/* Parse the arguments with the defaults. */
			$args = wp_parse_args( $args, array( 'label' => array( 'Template Name' ) ) );

			/* Get theme and templates variables. */
			$themes = get_themes();
			$theme = get_current_theme();
			$templates = $themes[$theme]['Template Files'];
			$post_templates = array();

			/* If there's an array of templates, loop through each template. */
			if ( is_array( $templates ) ) {

				/* Set up a $base path that we'll use to remove from the file name. */
				$base = array( trailingslashit( get_template_directory() ), trailingslashit( get_stylesheet_directory() ) );

				/* Loop through the post templates. */
				foreach ( $templates as $template ) {

					/* Remove the base (parent/child theme path) from the template file name. */
					$basename = str_replace( $base, '', $template );

					/* Get the template data. */
					$template_data = implode( '', file( $template ) );

					/* Make sure the name is set to an empty string. */
					$name = '';

					/* Loop through each of the potential labels and see if a match is found. */
					foreach ( $args['label'] as $label ) {
						if ( preg_match( "|^[\s\*]*{$label}:(.*)$|mi", $template_data, $name ) ) {
							$name = _cleanup_header_comment( $name[1] );
							break;
						}
					}

					/* If a post template was found, add its name and file name to the $post_templates array. */
					if ( !empty( $name ) )
						$post_templates[trim( $name )] = $basename;
				}
			}

			/* Return array of post templates. */
			return $post_templates;
		}


		/******************** END HELPER FUNCTIONS **********************/

	}


	if ( ! function_exists( 'soil_register_meta_box' ) && class_exists( 'soilMetaBox' ) ) {
		function soil_register_meta_box( $metabox ) {
			$custom_post = new soilMetaBox( $metabox );
		}
	}


}
