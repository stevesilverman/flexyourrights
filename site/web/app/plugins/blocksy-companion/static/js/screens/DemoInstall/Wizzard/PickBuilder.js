import {
	createElement,
	Component,
	useEffect,
	useState,
	useContext,
	createContext,
	Fragment
} from '@wordpress/element'
import { __ } from 'ct-i18n'
import classnames from 'classnames'
import { DemosContext } from '../../DemoInstall'
import { getNameForPlugin } from './Plugins'

const PickBuilder = ({ demoConfiguration, setDemoConfiguration, style }) => {
	const {
		currentDemo,
		demos_list,
		pluginsStatus,
		setCurrentDemo
	} = useContext(DemosContext)

	const [properDemoName, _] = (currentDemo || '').split(':')

	const demosCollection = demos_list.filter(
		({ name }) => name === properDemoName || ''
	)

	return (
		<div style={style}>
			{demosCollection.length > 1 && (
				<div className="ct-demo-builder">
					<i className="ct-demo-icon">
						<svg width="52" height="40" viewBox="0 0 52 40">
							<path
								fill="#DBE7EE"
								d="M0,38.1C0,39.1,0.9,40,1.8,40h39.3c1.1,0,1.8-0.9,1.8-1.9v-31H0V38.1z"
							/>
							<path
								fill="#CFDBE4"
								d="M13.8,14.6v18.8h22.6V14.6H13.8zM34.8,31.9H15.4V16.1h19.4V31.9z"
							/>
							<path
								fill="#BDC8D7"
								d="M13.1,15.3L13.1,15.3c0-0.8,0.6-1.4,1.4-1.4l0,0c0.8,0,1.4,0.6,1.4,1.4l0,0c0,0.8-0.6,1.4-1.4,1.4l0,0C13.7,16.8,13.1,16.1,13.1,15.3z M34.1,15.3L34.1,15.3c0-0.8,0.6-1.4,1.4-1.4l0,0c0.8,0,1.4,0.6,1.4,1.4l0,0c0,0.8-0.6,1.4-1.4,1.4l0,0C34.8,16.8,34.1,16.1,34.1,15.3z M13.1,32.7L13.1,32.7c0-0.8,0.6-1.4,1.4-1.4l0,0c0.8,0,1.4,0.6,1.4,1.4l0,0c0,0.8-0.6,1.4-1.4,1.4l0,0C13.7,34.1,13.1,33.5,13.1,32.7z M34.1,32.7L34.1,32.7c0-0.8,0.6-1.4,1.4-1.4l0,0c0.8,0,1.4,0.6,1.4,1.4l0,0c0,0.8-0.6,1.4-1.4,1.4l0,0C34.8,34.1,34.1,33.5,34.1,32.7z M23.3,15.3L23.3,15.3c0-0.8,0.6-1.4,1.4-1.4l0,0c0.8,0,1.4,0.6,1.4,1.4l0,0c0,0.8-0.6,1.4-1.4,1.4l0,0C24,16.8,23.3,16.1,23.3,15.3z M4.2,13.9h5.9v7.9H4.2V13.9zM4.2,23.3h5.9v2.9H4.2V23.3zM0,9V1.9C0,0.9,0.9,0,1.8,0h39.3c1.1,0,1.8,0.9,1.8,1.9V9H0z M42.9,35.4V10.9h-9.3v15.2L42.9,35.4zM7.2,27.6c-1.6,0-3,1.3-3,3c0,1.6,1.3,3,3,3s3-1.3,3-3C10.2,28.9,8.8,27.6,7.2,27.6z"
							/>
							<path
								fill="#0C7AB3"
								d="M50,27.8H35.6c-1.1,0-2-0.9-2-2v-18c0-1.1,0.9-2,2-2H50c1.1,0,2,0.9,2,2v18C52,26.9,51.1,27.8,50,27.8z"
							/>
							<path
								fill="#44ACDF"
								d="M49,17.5H36.8c-0.7,0-1.2-0.5-1.2-1.2V9.1c0-0.7,0.5-1.2,1.2-1.2H49c0.7,0,1.2,0.5,1.2,1.2v7.3C50.2,17,49.6,17.5,49,17.5z M50.2,20.4v-0.1c0-0.5-0.4-1-1-1H36.5c-0.5,0-1,0.4-1,1v0.1c0,0.5,0.4,1,1,1h12.7C49.7,21.4,50.2,20.9,50.2,20.4z M40.8,25.2h-4.3c-0.5,0-1-0.4-1-1v-0.1c0-0.5,0.4-1,1-1h4.3c0.5,0,1,0.4,1,1v0.1C41.7,24.8,41.3,25.2,40.8,25.2z M49.2,25.2h-4.3c-0.5,0-1-0.4-1-1v-0.1c0-0.5,0.4-1,1-1h4.3c0.5,0,1,0.4,1,1v0.1C50.2,24.8,49.7,25.2,49.2,25.2z"
							/>
							<path
								fill="#C8E6F4"
								d="M47.4,11.2h-9.1c-0.2,0-0.5-0.2-0.5-0.4v0c0-0.2,0.2-0.4,0.5-0.4h9.1c0.2,0,0.5,0.2,0.5,0.4v0C47.8,11,47.6,11.2,47.4,11.2z M47.9,14.7L47.9,14.7c0-0.2-0.2-0.5-0.5-0.5h-9.1c-0.2,0-0.4,0.2-0.4,0.4v0c0,0.2,0.2,0.4,0.4,0.4h9.1C47.7,15.1,47.9,14.9,47.9,14.7z"
							/>
							<path
								fill="#FFFFFF"
								d="M26.3,20.8h-2.9l-2.9,7.9H23l0.3-0.7h2.8l0.3,0.7h2.7L26.3,20.8z M23.9,25.8l0.8-2.2h0l0.8,2.2H23.9zM46.5,10.7c0,0.8-0.7,1.5-1.5,1.5s-1.5-0.7-1.5-1.5c0-0.8,0.7-1.5,1.5-1.5S46.5,9.9,46.5,10.7zM42.1,14.7c0,0.8-0.7,1.5-1.5,1.5s-1.5-0.7-1.5-1.5s0.7-1.5,1.5-1.5S42.1,13.9,42.1,14.7z"
							/>
						</svg>
					</i>

					<h2>{__('Choose Page Builder', 'blc')}</h2>

					<p>
						{__(
							'This demo template was built and is available to be used with one of these page builders. Please select your prefered one in order to continue.',
							'blc'
						)}
					</p>

					<ul>
						{demosCollection.map(({ builder, plugins }) => (
							<li
								className={classnames({
									active:
										builder ===
										(demoConfiguration.builder ||
											demosCollection[0].builder)
								})}
								onClick={() =>
									setDemoConfiguration({
										...demoConfiguration,
										builder,
										plugins: plugins.map(plugin => ({
											plugin,
											enabled: true
										}))
									})
								}>
								{getNameForPlugin(builder) || 'Gutenberg'}
							</li>
						))}
					</ul>
				</div>
			)}
		</div>
	)
}

export default PickBuilder
