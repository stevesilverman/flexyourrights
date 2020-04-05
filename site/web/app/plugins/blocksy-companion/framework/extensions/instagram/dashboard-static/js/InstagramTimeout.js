import {
	createElement,
	Component,
	useState,
	useEffect
} from '@wordpress/element'
import { __ } from 'ct-i18n'
import Downshift from 'downshift'
import classnames from 'classnames'
import { getValueFromInput, OptionsPanel } from 'blocksy-options'

let timeoutCache = '1:days'

const InstagramTimeout = () => {
	const [timeout, setInstagramTimeout] = useState(timeoutCache)

	const [number, unit] = timeout.split(':')

	const loadData = async () => {
		const body = new FormData()
		body.append('action', 'blocksy_get_instagram_interval')

		try {
			const response = await fetch(ctDashboardLocalizations.ajax_url, {
				method: 'POST',
				body
			})

			if (response.status === 200) {
				const { success, data } = await response.json()

				if (success) {
					timeoutCache = data.timeout
					setInstagramTimeout(data.timeout)
				}
			}
		} catch (e) {}
	}

	const saveTimeout = async () => {
		const body = new FormData()
		body.append('action', 'blocksy_update_instagram_interval')
		body.append('timeout', timeout)

		try {
			const response = await fetch(ctDashboardLocalizations.ajax_url, {
				method: 'POST',
				body
			})

			if (response.status === 200) {
				timeoutCache = timeout
			}
		} catch (e) {}
	}

	useEffect(() => {
		loadData()
	}, [])

	return (
		<div className="ct-instagram-timeout">
			<OptionsPanel
				onChange={(optionId, optionValue) => {
					let n = number
					let u = unit

					if (optionId === 'number') {
						n = optionValue
					}

					if (optionId === 'unit') {
						u = optionValue
					}

					setInstagramTimeout(`${n}:${u}`)
				}}
				options={{
					reset: {
						type: 'blocksy-instagram-reset',
						design: 'inline',
						label: false
					},

					title: {
						type: 'jsx',
						label: false,
						design: 'inline',
						render: () => (
							<p>
								{__(
									'Automatically check for new Instagram posts every:',
									'blc'
								)}
							</p>
						)
					},

					group: {
						type: 'ct-group',
						attr: {
							'data-columns': '3'
						},
						options: {
							number: {
								label: false,
								type: 'text',
								value: '1'
							},

							unit: {
								label: false,
								type: 'ct-select',
								value: 'days',
								choices: {
									minutes: __('Minutes', 'blc'),
									hours: __('Hours', 'blc'),
									days: __('Days', 'blc')
								}
							},

							jsx: {
								type: 'jsx',
								label: false,
								render: () => (
									<button
										className="ct-button ct-ig-save"
										onClick={e => {
											e.preventDefault()
											saveTimeout()
										}}>
										{__('Save Settings', 'blc')}
									</button>
								)
							}
						}
					}
				}}
				value={{
					number,
					unit
				}}
				hasRevertButton={false}
			/>
		</div>
	)
}

export default InstagramTimeout

