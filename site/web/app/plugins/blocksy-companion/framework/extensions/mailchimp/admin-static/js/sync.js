import {
	checkAndReplace,
	responsiveClassesFor
} from '../../../instagram/static/js/sync/helpers'

import './variables'

wp.customize('mailchimp_subscribe_visibility', val =>
	val.bind(to => {
		const block = document.querySelector('.ct-mailchimp-block')
		responsiveClassesFor('mailchimp_subscribe_visibility', block)
	})
)

if (
	document.body.classList.contains('single') ||
	document.body.classList.contains('page')
) {
	checkAndReplace({
		id: 'mailchimp_single_post_enabled',
		strategy: 'append',

		parent_selector: '.content-area article',
		selector: '.ct-mailchimp-block',
		fragment_id: 'blocksy-mailchimp-subscribe',

		watch: [
			'has_mailchimp_name',
			'mailchimp_button_text',
			'mailchimp_title',
			'mailchimp_text',
			'mailchimp_name_label',
			'mailchimp_mail_label'
		],

		whenInserted: () => {
			if (
				!document.body.classList.contains('single') &&
				!document.body.classList.contains('page')
			) {
				return
			}
			const block = document.querySelector('.ct-mailchimp-block')

			responsiveClassesFor('mailchimp_subscribe_visibility', block)

			if (wp.customize('has_mailchimp_name')() !== 'yes') {
				block.querySelector('[name="FNAME"]').remove()
			} else {
				block
					.querySelector('[name="FNAME"]')
					.setAttribute(
						'placeholder',
						`${wp.customize('mailchimp_name_label')()}`
					)
			}

			block
				.querySelector('[name="EMAIL"]')
				.setAttribute(
					'placeholder',
					`${wp.customize('mailchimp_mail_label')()} *`
				)

			block.querySelector('button').innerHTML = wp.customize(
				'mailchimp_button_text'
			)()

			block.querySelector('h4').innerHTML = wp.customize(
				'mailchimp_title'
			)()

			block.querySelector(
				'.ct-mailchimp-description'
			).innerHTML = wp.customize('mailchimp_text')()
		}
	})
}
