import './public-path'
import './ct-events'
import { onDocumentLoaded } from './helpers'

import ctEvents from 'ct-events'

onDocumentLoaded(() => {
	const getEls = () => [
		...document.querySelectorAll('.ct-instagram-widget'),
		...document.querySelectorAll('.ct-instagram-block')
	]

	getEls().map(el =>
		import('./instagram-widget').then(({ initInstagramWidget }) => {
			initInstagramWidget(el)
		})
	)

	ctEvents.on('blocksy:instagram:init', () =>
		getEls().map(el =>
			import('./instagram-widget').then(({ initInstagramWidget }) => {
				initInstagramWidget(el)
			})
		)
	)
})
