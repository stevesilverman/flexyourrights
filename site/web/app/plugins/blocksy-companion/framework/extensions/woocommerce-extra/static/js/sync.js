import './variables'
import '../../../instagram/static/js/ct-events'
import ctEvents from 'ct-events'

import {
	checkAndReplace,
	responsiveClassesFor
} from '../../../instagram/static/js/sync/helpers'

wp.customize('woocommerce_quickview_enabled', val =>
	val.bind(to => ctEvents.trigger('ct:archive-product-replace-cards:perform'))
)

ctEvents.on('ct:archive-product-replace-cards:update', ({ product }) => {
	if (product.querySelector('.ct-open-quick-view')) {
		if (wp.customize('woocommerce_quickview_enabled')() === 'no') {
			product.querySelector('.ct-open-quick-view').dataset.customizeHide =
				''
		} else {
			product
				.querySelector('.ct-open-quick-view')
				.removeAttribute('data-customize-hide')
		}

		ctEvents.trigger('ct:quick-view:update')
	}
})

checkAndReplace({
	id: 'has_floating_bar',
	strategy: 'append',

	parent_selector: 'body',
	selector: '.ct-floating-bar',
	fragment_id: 'blocksy-woo-floating-cart',

	whenInserted: () => ctEvents.trigger('blocksy:woo:floating-cart:init')
})
