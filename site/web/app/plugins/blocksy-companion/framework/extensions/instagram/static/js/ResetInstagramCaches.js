import { createElement, Component, useState } from '@wordpress/element'
import { __ } from 'ct-i18n'

const ResetInstagramCaches = props => {
	// idle | loading | done
	const [buttonState, setButtonState] = useState('idle')

	return (
		<div className="ct-reset-instagram-caches">
			<button
				className="button"
				onClick={e => {
					e.preventDefault()

					setButtonState('loading')

					const body = new FormData()
					body.append('action', 'blocksy_reset_instagram_transients')

					fetch(ajaxurl, {
						method: 'POST',
						body
					}).then(() => {
						setButtonState('done')
						setTimeout(() => setButtonState('idle'), 3000)
					})
				}}>
				{
					{
						loading: __('Checking...', 'blc'),
						done: __('Done', 'blc'),
						idle: __('Check', 'blc')
					}[buttonState]
				}
			</button>
		</div>
	)
}

// ResetInstagramCaches.renderingConfig = { design: 'none' }

export default ResetInstagramCaches
