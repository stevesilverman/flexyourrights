<?php

add_action('wp_ajax_blocsky_get_woo_quick_view', 'blocksy_get_woocommerce_quickview');
add_action('wp_ajax_nopriv_blocsky_get_woo_quick_view', 'blocksy_get_woocommerce_quickview');

function blocksy_get_woocommerce_quickview() {
	global $product;
	global $post;

	$product = wc_get_product(sanitize_text_field( $_GET['product_id'] ));

	$GLOBALS['product'] = $product;

	$id = $product->get_id();

	$post = get_post($id);

	if (! $product) {
		wp_send_json_error();
	}

	$is_in_stock = true;

	if (! $product->managing_stock() && ! $product->is_in_stock()) {
		$is_in_stock = false;
	}

	$content = ob_start();

	?>

	<div id="quick-view-<?php echo esc_attr($id) ?>" data-behaviour="modal" class="ct-panel quick-view-modal">
		<div class="content-container" data-align="middle">
			<div <?php wc_product_class('ct-container', $product->get_id()) ?>>
				<section class="ct-quick-view-images">
					<?php woocommerce_show_product_sale_flash() ?>
					<?php woocommerce_show_product_images() ?>
				</section>

				<section class="ct-quick-view-summary">
					<div class="close-button">
						<span class="ct-trigger closed"><span></span></span>
					</div>

					<div class="entry-summary">
						<?php
							woocommerce_template_single_title();
							woocommerce_template_single_price();
							woocommerce_template_single_excerpt();
							woocommerce_template_single_add_to_cart();
						?>
					</div>

					<div class="ct-quick-view-actions">
						<?php if ($is_in_stock) { ?>
							<a href="#" class="ct-quick-add"><?php echo __('Add To Cart', 'blc') ?></a>
						<?php } ?>
						<a href="<?php echo get_permalink($product->get_id()) ?>" class="ct-quick-more">
							<?php echo __('More Information', 'blc') ?>
						</a>
					</div>
				</section>
			</div>

		</div>
	</div>

	<?php

	wp_send_json_success([
		'quickview' => ob_get_clean()
	]);
}

function blocksy_output_quick_view_link($for_preview = false) {
    global $product;

	$id = $product->get_id();

	if (
		get_theme_mod('woocommerce_quickview_enabled', 'yes') === 'yes'
		||
		is_customize_preview()
	) {
		$attr = '';

		if (is_customize_preview()) {
			$attr = 'data-customize-hide';
		}

		return '<a href="#quick-view-' . $id . '" class="ct-open-quick-view" ' . $attr . '><span hidden>' . __('Quick view', 'blocksy') . '</span><svg width="16" height="16" viewBox="0 0 40 40"><path d="M39.6,18.6C34.9,11.5,29.2,5,20,5C10.8,5,5.1,11.5,0.4,18.6c-0.6,0.8-0.6,1.9,0,2.8C5.1,28.5,10.8,35,20,35s14.9-6.5,19.6-13.6C40.1,20.5,40.1,19.5,39.6,18.6z M20,30.7c-5.7,0-10.1-3-15.5-10.7C9.9,12.3,14.3,9.3,20,9.3s10.1,3,15.5,10.7C30.1,27.7,25.7,30.7,20,30.7zM25,20c0,2.8-2.2,5-5,5s-5-2.2-5-5s2.2-5,5-5C22.8,15,25,17.2,25,20z"/></svg><span data-loader="circles"><span></span><span></span><span></span></span></a>';
	}

	return '';
}

function blc_output_woo_floating_cart_cache() {
	if (! is_customize_preview()) return;

	blocksy_add_customizer_preview_cache(
		blocksy_html_tag(
			'div',
			[ 'data-id' => 'blocksy-woo-floating-cart' ],
			blocksy_woo_floating_cart(true)
		)
	);
}

function blocksy_woo_product_check_required_addons(
	$product_id, $check_for_required = true
) {
	if (! class_exists('WC_Product_Addons_Helper')) {
		return false;
	}

	// No parent add-ons, but yes to global.
	$addons = WC_Product_Addons_Helper::get_product_addons(
		$product_id,
		false,
		false,
		true
	);

	if ($addons && !empty($addons)) {
		foreach ($addons as $addon) {
			if (isset($addon['required']) && '1' == $addon['required']) {
				return true;
			}
		}
	}

	return false;
}

function blocksy_woo_product_addons_change_text($text, $product = null) {
	if (null === $product) {
		global $product;
	}

	if (! is_a($product, 'WC_Product')) {
		return $text;
	}

	return __('Select options', 'blc');
}

function blocksy_woo_floating_cart($forced = false) {
	if (! function_exists('is_woocommerce')) {
		return '';
	}

	global $product;

	if (! is_product()) {
		return '';
	}

	if (! $forced) {
		blc_output_woo_floating_cart_cache();
	}

	if (get_theme_mod('has_floating_bar', 'yes') !== 'yes') {
		if (! $forced) {
			return '';
		}
	}

	$image_output = blocksy_image([
		'attachment_id' => $product->get_image_id(),
		'size' => 'woocommerce_gallery_thumbnail',
		'ratio' => '1/1',
		'lazyload' => false,
		'tag_name' => 'div',
	]);

	ob_start();

	?>
		<div class="ct-floating-bar">
			<div class="ct-container">
				<section>
					<?php echo $image_output ?>

					<?php woocommerce_template_single_title() ?>
				</section>

				<section>
					<?php
						woocommerce_template_single_price();

						if (blocksy_woo_product_check_required_addons($product->get_id())) {
							add_filter('woocommerce_product_add_to_cart_text', 'blocksy_woo_product_addons_change_text', 15);
							woocommerce_template_loop_add_to_cart();
							remove_filter('woocommerce_product_add_to_cart_text', 'blocksy_woo_product_addons_change_text', 15);
						} else {
							if ($product->is_type('simple')) {
								global $wp_filter;

								if (isset($wp_filter['woocommerce_before_add_to_cart_quantity'])) {
									$old_before = $wp_filter['woocommerce_before_add_to_cart_quantity'];
								}

								if (isset($wp_filter['woocommerce_after_add_to_cart_quantity'])) {
									$old = $wp_filter['woocommerce_after_add_to_cart_quantity'];
								}

								if (isset($wp_filter['woocommerce_before_add_to_cart_button'])) {
									$old_button = $wp_filter['woocommerce_before_add_to_cart_button'];
								}

								unset($wp_filter['woocommerce_before_add_to_cart_quantity']);
								unset($wp_filter['woocommerce_after_add_to_cart_quantity']);
								unset($wp_filter['woocommerce_before_add_to_cart_button']);

								woocommerce_simple_add_to_cart();

								if (isset($old_before)) {
									$wp_filter['woocommerce_before_add_to_cart_quantity'] = $old_before;
								}

								if (isset($old)) {
									$wp_filter['woocommerce_after_add_to_cart_quantity'] = $old;
								}

								if (isset($old_button)) {
									$wp_filter['woocommerce_before_add_to_cart_button'] = $old_button;
								}
							} else {
								woocommerce_template_loop_add_to_cart();
							}
						}
					?>
				</section>
			</div>
		</div>

	<?php


	return ob_get_clean();
}

