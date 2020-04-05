import {
	createElement,
	Component,
	useEffect,
	useState,
	Fragment
} from '@wordpress/element'

import { Transition } from 'react-spring/renderprops'
import {
	Dialog,
	DialogOverlay,
	DialogContent
} from '../../../../../static/js/helpers/reach/dialog'
import classnames from 'classnames'
import { __, sprintf } from 'ct-i18n'
import Overlay from '../../../../../static/js/helpers/Overlay'

import InstagramTimeout from './InstagramTimeout'

const EditSettings = () => {
	const [isLoading, setIsLoading] = useState(false)
	const [isEditing, setIsEditing] = useState(false)

	return (
		<Fragment>
			<button
				className="ct-minimal-button ct-config-btn dashicons dashicons-admin-generic"
				onClick={() => setIsEditing(true)}>
			</button>

			<Overlay
				items={isEditing}
				onDismiss={() => setIsEditing(false)}
				render={() => (
					<div
						className={classnames(
							'ct-instagram-edit-settings ct-extension-config'
						)}>
						<h1>{__('Instagram Settings', 'blc')}</h1>

						<p>
							{__(
								'The Instagram extension uses caching functionality to improve the performance of your website and limit the requests made to the API.',
								'blc'
							)}
						</p>

						<p>
							{__(
								"If you don't see your recently added photos from Instagram then click the button below or set a different time for automatic checks.",
								'blc'
							)}
						</p>

						<InstagramTimeout />
					</div>
				)}
			/>
		</Fragment>
	)
}

export default EditSettings
