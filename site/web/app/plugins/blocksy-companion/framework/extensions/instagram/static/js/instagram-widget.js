import ctEvents from 'ct-events'
import { markImagesAsLoaded } from './lazy-load-helpers'

export const initInstagramWidget = el => {
	if (!el.querySelector('ul[data-widget]')) {
		markImagesAsLoaded(el.querySelector('ul'))
		return
	}

	if (!window.fetch) return

	const { limit, username } = JSON.parse(
		el.querySelector('ul').dataset.widget
	)

	el.querySelector('ul').removeAttribute('data-widget')

	fetch(
		`${
			blocksy_ext_instagram_localization.ajax_url
		}?action=blocksy_widget_instagram&limit=${limit}&username=${username}`
	)
		.then(r => r.text())
		.then(text => {
			el.querySelector('ul').removeAttribute('class')
			el.querySelector('ul').innerHTML = text

			if (el.querySelector('ul').innerHTML.trim().length === 0) {
				el.remove()
			}

			el.classList.remove('ct-empty')

			ctEvents.trigger('ct:images:lazyload:update')
		})
}
