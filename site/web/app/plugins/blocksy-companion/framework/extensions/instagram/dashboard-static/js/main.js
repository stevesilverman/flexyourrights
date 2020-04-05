import '../../static/js/ct-events'
import {
	createElement,
	Component,
	useEffect,
	useState,
	Fragment
} from '@wordpress/element'

import Instagram from './Instagram'

import ctEvents from 'ct-events'
import ResetInstagramCaches from './ResetInstagramCaches'

ctEvents.on('blocksy:options:register', opts => {
	opts['blocksy-instagram-reset'] = ResetInstagramCaches
})

ctEvents.on('ct:extensions:card', ({ CustomComponent, extension }) => {
	if (extension.name !== 'instagram') return
	CustomComponent.extension = Instagram
})
