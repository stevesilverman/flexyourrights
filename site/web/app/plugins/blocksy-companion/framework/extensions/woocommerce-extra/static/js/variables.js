import { handleVariablesFor } from 'customizer-sync-helpers'

handleVariablesFor({
	floatingBarFontColor: {
		selector: '.ct-floating-bar',
		variable: 'color',
		type: 'color'
	},

	floatingBarBackground: {
		selector: '.ct-floating-bar',
		variable: 'backgroundColor',
		type: 'color'
	},

	floatingBarShadow: {
		selector: '.ct-floating-bar',
		type: 'box-shadow',
		variable: 'boxShadow',
		responsive: true
	}
})
