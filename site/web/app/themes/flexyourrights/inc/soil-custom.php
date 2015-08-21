<?php

// ====================================
// Class Over-rides
// ====================================

/**
 * soilCustomUtil
 * Extends the soilUtil Class.
 *
 * @author Blue Riot Labs
 * @uses soilUtil/scbUtil
 */
class soilCustomUtil extends soilUtil {

}


/**
 * soilCustomOptions
 * Extends the soilOptions Class.
 *
 * @author Blue Riot Labs
 * @uses soilOptions/scbOptions
 */
class soilCustomOptions extends soilOptions {
  public function __construct( $key, $file, $defaults = array() ) {
    parent::__construct( $key, $file, $defaults );
  }
}


/**
 * soilCustomForms
 * Extends the soilForms Class.
 *
 * @author Blue Riot Labs
 * @uses soilForms/soilForm/scbForms/scbForm
 */
class soilCustomForms extends soilForms {

}


/**
 * soilCustomForm
 * Extends the soilForm Class.
 *
 * @author Blue Riot Labs
 * @uses soilForm/scbForm
 */
class soilCustomForm extends soilForm {
  function __construct( $data, $prefix = false ) {
    parent::__construct( $data, $prefix );
  }
}


/**
 * soilCustomTable
 * Extends the soilTable Class.
 *
 * @author Blue Riot Labs
 * @uses soilTable/scbTable
 */
class soilCustomTable extends soilTable {
  function __construct( $name, $file, $columns, $upgrade_method = 'dbDelta' ) {
    parent::__construct( $name, $file, $columns, $upgrade_method );
  }
}


/**
 * soilCustomWidget
 * Extends the soilWidget Class.
 *
 * @author Blue Riot Labs
 * @uses soilWidget/scbWidget
 */
abstract class soilCustomWidget extends soilWidget {

}


/**
 * soilCustomAdminPage
 * Extends the soilAdminPage Class.
 *
 * @author Blue Riot Labs
 * @uses soilAdminPage/scbAdminPage
 */
abstract class soilCustomAdminPage extends soilAdminPage {
  function __construct( $file, $options = null ) {
    parent::__construct( $file, $options );
  }
}


/**
 * soilCustomBoxesPage
 * Extends the soilTable Class.
 *
 * @author Blue Riot Labs
 * @uses soilBoxesPage/scbBoxesPage
 */
abstract class soilCustomBoxesPage extends soilBoxesPage {
  function __construct( $file, $options = null ) {
    parent::__construct( $file, $options );
  }
}


/**
 * soilCustomCron
 * Extends the soilCron Class.
 *
 * @author Blue Riot Labs
 * @uses soilCron/scbForm
*/
class soilCustomCron extends soilCron {
  function __construct( $data, $prefix = false ) {
    parent::__construct( $data, $prefix );
  }
}


/**
 * soilCustomHooks
 * Extends the soilHooks Class.
 *
 * @author Blue Riot Labs
 * @uses soilHooks/scbHooks
 */
class soilCustomHooks extends soilHooks {

}


/*
 * soilCustomRegisterTaxonomy
 * Extends the soilRegisterTaxonomy Class.
 *
 * @author Blue Riot Labs
 * @uses soilRegisterTaxonomy
*/
class soilCustomRegisterTaxonomy extends soilRegisterTaxonomy {
  public function __construct( $taxonomy = null,  $post_types = null, $sing_name = null, $args = array(), $plural_name = null ) {
    parent::__construct( $taxonomy,  $post_types, $sing_name, $args, $plural_name );
  }
}


/**
 * soilCustomRegisterPostType
 * Extends the soilRegisterPostType Class.
 *
 * @author Blue Riot Labs
 * @uses soilRegisterTaxonomy
 */
class soilCustomRegisterPostType extends soilRegisterPostType {

  protected $defaults = array(
    'show_ui' => true,
    'public' => true,
    'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'),
    'publicly_queryable' => true,
    'exclude_from_search' => false,
    'capability_type' => 'page',
    'query_var' => true,
    'rewrite' => true,
    'has_archive' => true,
  );

  public function __construct( $post_type = null, $args = array(), $custom_plural = false ) {

    $this->set_defaults();
    $modified_args = wp_parse_args( $args, $this->defaults );

    parent::__construct( $post_type, $modified_args, $custom_plural );
  }


  public function set_defaults() {

    $plural = $this->post_type_plural;
    $singular = $this->post_type_name;

    $this->defaults['labels'] = array(
      'name' => $plural,
      'singular_name' => $singular,
      'add_new_item' => 'Add New ' . $singular,
      'edit_item' => 'Edit ' . $singular,
      'new_item' => 'New ' . $singular,
      'view_item' => 'View ' . $singular,
      'search_items' => 'Search ' . $plural,
      'not_found' => 'No ' . $plural . ' found',
      'not_found_in_trash' => 'No ' . $plural . ' found in Trash'
    );

  }

}


/**
 * soilCustomMetaBox
 * Extends the soilMetaBox Class.
 *
 * @author Blue Riot Labs
 * @uses soilMetaBox
 */
class soilCustomMetaBox extends soilMetaBox {

  /** Create a new meta box based on given data */
  function __construct($meta_box) {

    parent::__construct( $meta_box );
    // run script only in admin area
    if (!is_admin()) return;

    // check to see if we need to load stuff for images
    $this->check_field_image();

  }


  /** Check field upload and add needed actions */
  function check_field_image() {
    if ( $this->has_field('resource') ) {

      // load default media support
      $this->load_media_support();

      // add custom js for resources
      wp_enqueue_script( 'soil-custom-admin-js', THEME_URI . '/js/admin.js', array( 'soil-attachments' ), null, true );

      // add custom js for resources
      wp_enqueue_style( 'soil-custom-admin-css', THEME_URI . '/css/admin.css', array( 'soil-meta-box-css' ) );
    }
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


  /** File Resource - Draggable & Orderable */
  function show_field_resource($field, $meta) {
    global $temp_ID; $data=array();

        $media_upload_iframe_src = "media-upload.php?post_id=$temp_ID&TB_iframe=1";
        $image_upload_iframe_src = apply_filters( 'image_upload_iframe_src', "$media_upload_iframe_src" );

    $data['id'] = "{$field['id']}";
    $data['upload_iframe_src'] = $image_upload_iframe_src;
    $data['upload_handler'] = 'handle_content_update_resource'; // specific js handler
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
        'attachment_thumb' => isset($attachment['id'])
          ? wp_get_attachment_image( $attachment['id'], array(90, 90), 1 ) : '',
        'attachment_id' => isset($attachment['id']) ? $attachment['id'] : '',
      );

    } # end foreach meta

    echo soil_mustache_render( 'resource.html', $data );
  }


  /** Save Resource */
  function save_field_resource($post_id, $field, $old, $new) {

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


}




// ====================================
// Functions pass throughs / over-rides
// ====================================


/**
 * soilCustom_register_taxonomy
 * A helper function for the soilCustomRegisterTaxonomy class.
 */
if ( ! function_exists( 'soil_register_custom_taxonomy' ) && class_exists( 'soilCustomRegisterTaxonomy' ) ) {
  function soil_register_custom_taxonomy( $taxonomy = null,  $post_types = null, $sing_name = null, $args = array(), $plural_name = null ) {
    $custom_taxonomy = new soilCustomRegisterTaxonomy( $taxonomy, $post_types, $sing_name, $args, $plural_name );
  }
}


/**
 * soilCustomRegisterPostType
 * A helper function for the soilRegisterPostType class.
 */
if ( ! function_exists( 'soil_register_custom_post_type' ) && class_exists( 'soilCustomRegisterPostType' ) ) {
  function soil_register_custom_post_type( $post_type = null, $args=array(), $custom_plural = false ) {
    $custom_post = new soilCustomRegisterPostType( $post_type, $args, $custom_plural );
  }
}


/**
 * soilCustom_register_meta_box
 * A helper function for the soilRegisterPostType class.
 */
if ( ! function_exists( 'soil_register_custom_meta_box' ) && class_exists( 'soilCustomMetaBox' ) ) {
  function soil_register_custom_meta_box( $metabox ) {
    $custom_post = new soilCustomMetaBox( $metabox );
  }
}