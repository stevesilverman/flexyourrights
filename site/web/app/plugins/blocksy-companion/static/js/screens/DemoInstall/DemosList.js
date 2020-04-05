import {
	createElement,
	Component,
	useEffect,
	useState,
	createContext,
	useContext,
	Fragment
} from '@wordpress/element'
import { __ } from 'ct-i18n'
import classnames from 'classnames'
import { DemosContext } from '../DemoInstall'
import DashboardContext from '../../DashboardContext'

const DemosList = () => {
	const {
		currentlyInstalledDemo,
		demos_list,
		setCurrentDemo,
		demo_error
	} = useContext(DemosContext)
	const { Link } = useContext(DashboardContext)

	return (
		<ul>
			{demos_list
				.filter(
					(v, i) =>
						demos_list.map(({ name }) => name).indexOf(v.name) === i
				)
				.filter(ext => !ext.dev || ct_localizations.is_dev_mode)
				.map(demo => (
					<li
						key={demo.name}
						className={classnames('ct-single-demo', {
							'ct-is-pro': demo.is_pro
						})}>
						<figure>
							<img src={demo.screenshot} />

							{demo.is_pro && (
								<a onClick={e => e.preventDefault()} href="#">
									PRO
								</a>
							)}
						</figure>

						<div className="ct-demo-actions">
							<h4>{demo.name}</h4>

							<div>
								<a
									className="ct-button"
									target="_blank"
									href={demo.url}>
									{__('Preview', 'blc')}
								</a>
								<button
									className="ct-button-primary"
									onClick={() => setCurrentDemo(demo.name)}
									disabled={!!demo_error}>
									{currentlyInstalledDemo &&
									currentlyInstalledDemo.demo ===
										`${demo.name}:${demo.builder}`
										? __('Modify', 'blc')
										: __('Import', 'blc')}
								</button>
							</div>
						</div>
					</li>
				))}
		</ul>
	)
}

export default DemosList
