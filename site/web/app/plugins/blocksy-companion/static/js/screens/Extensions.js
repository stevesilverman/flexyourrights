import {
	createElement,
	Component,
	useEffect,
	useState,
	Fragment
} from '@wordpress/element'
import { __ } from 'ct-i18n'
import classnames from 'classnames'
import useExtensionReadme from '../helpers/useExtensionReadme'
import useActivationAction from '../helpers/useActivationAction'
import { Transition, animated } from 'react-spring/renderprops'
import SubmitSupport from '../helpers/SubmitSupport'

let exts_status_cache = null

const Extension = ({ extension, onExtsSync }) => {
	const [showReadme, readme] = useExtensionReadme(extension)
	const [isLoading, activationAction] = useActivationAction(extension, () => {
		onExtsSync()
	})

	return (
		<li className={classnames({ active: !!extension.__object })}>
			<h4 className="ct-extension-title">
				{extension.config.name}

				{isLoading && (
					<svg width="15" height="15" viewBox="0 0 100 100">
						<g transform="translate(50,50)">
							<g transform="scale(1)">
								<circle cx="0" cy="0" r="50" fill="#687c93" />
								<circle
									cx="0"
									cy="-26"
									r="12"
									fill="#ffffff"
									transform="rotate(161.634)">
									<animateTransform
										attributeName="transform"
										type="rotate"
										calcMode="linear"
										values="0 0 0;360 0 0"
										keyTimes="0;1"
										dur="1s"
										begin="0s"
										repeatCount="indefinite"
									/>
								</circle>
							</g>
						</g>
					</svg>
				)}
			</h4>

			{extension.config.description && (
				<div className="ct-extension-description">
					{extension.config.description}
				</div>
			)}

			<div className="ct-extension-actions">
				<button
					className={classnames(
						extension.__object ? 'ct-button' : 'ct-button-primary'
					)}
					data-hover="white"
					disabled={isLoading}
					onClick={() => {
						activationAction()
					}}>
					{extension.__object
						? __('Deactivate', 'blc')
						: __('Activate', 'blc')}
				</button>

				{extension.readme && (
					<button
						onClick={() => showReadme()}
						className="ct-minimal-button ct-instruction">
						<svg width="16" height="16" viewBox="0 0 24 24">
							<path d="M12,2C6.477,2,2,6.477,2,12s4.477,10,10,10s10-4.477,10-10S17.523,2,12,2z M12,17L12,17c-0.552,0-1-0.448-1-1v-4 c0-0.552,0.448-1,1-1h0c0.552,0,1,0.448,1,1v4C13,16.552,12.552,17,12,17z M12.5,9h-1C11.224,9,11,8.776,11,8.5v-1 C11,7.224,11.224,7,11.5,7h1C12.776,7,13,7.224,13,7.5v1C13,8.776,12.776,9,12.5,9z" />
						</svg>
					</button>
				)}
			</div>

			{readme}
		</li>
	)
}

const Extensions = () => {
	const [isLoading, setIsLoading] = useState(!exts_status_cache)
	const [exts_status, setExtsStatus] = useState(exts_status_cache || [])

	const syncExts = async (verbose = false) => {
		if (verbose) {
			setIsLoading(true)
		}

		const body = new FormData()
		body.append('action', 'blocksy_extensions_status')

		try {
			const response = await fetch(ctDashboardLocalizations.ajax_url, {
				method: 'POST',
				body
			})

			if (response.status === 200) {
				const { success, data } = await response.json()

				if (success) {
					setExtsStatus(data)
					exts_status_cache = data
				}
			}
		} catch (e) {}

		setIsLoading(false)
	}

	useEffect(() => {
		syncExts(!exts_status_cache)
	}, [])

	const exts = Object.values(exts_status).map((ext, index) => {
		ext['name'] = Object.keys(exts_status)[index]
		return ext
	})

	return (
		<div className="ct-extensions-list">
			<Transition
				items={isLoading}
				from={{ opacity: 0 }}
				enter={[{ opacity: 1 }]}
				leave={[{ opacity: 0 }]}
				initial={null}
				config={(key, phase) => {
					return phase === 'leave'
						? {
								duration: 300
							}
						: {
								delay: 300,
								duration: 300
							}
				}}>
				{isLoading => {
					if (isLoading) {
						return props => (
							<animated.p
								style={props}
								className="ct-loading-text">
								<span />

								{__('Loading Extensions Status...', 'blc')}
							</animated.p>
						)
					}

					return props => (
						<animated.div style={props}>
							{exts.length > 0 && (
								<Fragment>
									<div className="ct-info">
										<i />

										<p>
											{__(
												'Supercharge your website with the help of this extensions. Enhance your Shop, display your Instagram feed, add a Trending Posts widget, collect subscribers and more...',
												'blc'
											)}
										</p>
									</div>

									<ul>
										{exts.map(ext => {
											let CustomComponent = {
												extension: Extension
											}

											ctEvents.trigger(
												'ct:extensions:card',
												{
													CustomComponent,
													extension: ext
												}
											)

											return (
												<CustomComponent.extension
													key={ext.name}
													extension={ext}
													onExtsSync={() => {
														exts_status[
															ext.name
														].__object = !exts_status[
															ext.name
														].__object

														setExtsStatus(
															exts_status
														)
														syncExts()
													}}
												/>
											)
										})}
									</ul>

									<SubmitSupport />
								</Fragment>
							)}
						</animated.div>
					)
				}}
			</Transition>
		</div>
	)
}

export default Extensions
