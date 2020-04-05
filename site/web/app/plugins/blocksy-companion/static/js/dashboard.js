import { createElement, Component } from '@wordpress/element'
import * as check from '@wordpress/element'

import { __ } from 'ct-i18n'

import Extensions from './screens/Extensions'
import DemoInstall from './screens/DemoInstall'
import SiteExport from './screens/SiteExport'
import DemoToInstall from './screens/DemoInstall/DemoToInstall'
import OptIn from './screens/OptIn'

ctEvents.on('ct:dashboard:routes', r => {
	r.push({
		Component: () => <Extensions />,
		path: '/extensions'
	})

	r.push({
		Component: props => <DemoInstall {...props} />,
		path: '/demos'
	})
})

ctEvents.on('ct:dashboard:navigation-links', r => {
	r.push({
		text: __('Starter Sites', 'blc'),
		path: 'demos',
		getProps: ({ isPartiallyCurrent, isCurrent }) =>
			isPartiallyCurrent
				? {
						'aria-current': 'page'
					}
				: {}
	})

	r.push({
		text: __('Extensions', 'blc'),
		path: '/extensions'
	})
})

ctEvents.on('ct:dashboard:home:before', r => {
	if (!ctDashboardLocalizations.plugin_data.is_anonymous) {
		return
	}

	r.content = <OptIn />
})
