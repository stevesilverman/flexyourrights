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
import ListPicker from './ListPicker'

const EditCredentials = ({
	extension,
	isEditingCredentials,
	setIsEditingCredentials,
	onCredentialsValidated
}) => {
	const [apiKey, setApiKey] = useState(extension.data.api_key)
	const [listId, setListId] = useState(extension.data.list_id)
	const [isLoading, setIsLoading] = useState(false)
	const [isApiKeyInvalid, makeKeyInvalid] = useState(false)

	const attemptToSaveCredentials = async () => {
		const body = new FormData()

		body.append('api_key', apiKey)
		body.append('list_id', listId)

		body.append('action', 'blocksy_ext_mailchimp_maybe_save_credentials')

		setIsLoading(true)

		try {
			const response = await fetch(ctDashboardLocalizations.ajax_url, {
				method: 'POST',
				body
			})

			if (response.status === 200) {
				const body = await response.json()

				if (body.success) {
					if (body.data.result !== 'api_key_invalid') {
						onCredentialsValidated()
						makeKeyInvalid(false)
					}
				}
			}

			makeKeyInvalid(true)
		} catch (e) {
			makeKeyInvalid(true)
		}

		await new Promise(r => setTimeout(() => r(), 1000))

		setIsLoading(false)
	}

	return (
		<Transition
			items={isEditingCredentials}
			config={{ duration: 200 }}
			from={{ opacity: 0, y: -10 }}
			enter={{ opacity: 1, y: 0 }}
			leave={{ opacity: 0, y: 10 }}>
			{isEditingCredentials =>
				isEditingCredentials &&
				(props => (
					<DialogOverlay
						container={document.querySelector('#wpbody')}
						style={{ opacity: props.opacity }}
						onDismiss={() => setIsEditingCredentials(false)}>
						<DialogContent
							style={{
								transform: `translate3d(0px, ${props.y}px, 0px)`
							}}>
							<button
								className="close-button"
								onClick={() => setIsEditingCredentials(false)}>
								×
							</button>

							<div
								className={classnames(
									'ct-mailchimp-edit-credentials ct-extension-config',
									{
										'ct-key-invalid': isApiKeyInvalid
									}
								)}>
								<h1>{__('MailChimp Credentials', 'blc')}</h1>
								<p
									dangerouslySetInnerHTML={{
										__html: sprintf(
											__(
												'Enter your MailChimp credentials in the form below. More info on how to generate an API key can be found %shere%s.',
												'blc'
											),
											'<a target="_blank" href="https://mailchimp.com/help/about-api-keys/">',
											'</a>'
										)
									}}
								/>

								<ul className="mailchimp-credentials">
									<li>
										<label>{__('API Key', 'blc')}</label>

										<div className="ct-option-input">
											<input
												type="text"
												onChange={({ target: { value } }) =>
													setApiKey(value)
												}
												value={apiKey || ''}
											/>
										</div>
									</li>

									<li>
										<label>{__('List ID', 'blc')}</label>

										<ListPicker
											listId={listId}
											onChange={id => setListId(id)}
											apiKey={apiKey}
										/>
									</li>

									<li>
										<button
											className="ct-button"
											data-button="blue"
											disabled={
												!apiKey || !listId || isLoading
											}
											onClick={() =>
												attemptToSaveCredentials()
											}>
											{isLoading
												? __('Loading...', 'blc')
												: !extension.__object
													? __('Activate', 'blc')
													: __('Save Settings', 'blc')}
										</button>
									</li>
								</ul>
							</div>
						</DialogContent>
					</DialogOverlay>
				))
			}
		</Transition>
	)
}

export default EditCredentials
