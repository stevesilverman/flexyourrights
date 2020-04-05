import './public-path'
import { createElement, Fragment, Component } from '@wordpress/element'
import ListPicker from './ListPicker'

document.addEventListener('DOMContentLoaded', () =>
	ctEvents.on('blocksy:options:register', opts => {
		opts['blocksy-mailchimp'] = ListPicker
	})
)
