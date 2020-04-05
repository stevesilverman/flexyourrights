import {
	createElement,
	Component,
	useEffect,
	useState,
	Fragment
} from '@wordpress/element'
import { Transition } from 'react-spring/renderprops'
import { Dialog, DialogOverlay, DialogContent } from './reach/dialog'
import '@reach/dialog/styles.css'

const useExtensionReadme = extension => {
	const [showReadme, setIsShowingReadme] = useState(false)

	return [
		() => setIsShowingReadme(true),

		<Transition
			items={showReadme}
			config={{ duration: 200 }}
			from={{ opacity: 0, y: -10 }}
			enter={{ opacity: 1, y: 0 }}
			leave={{ opacity: 0, y: 10 }}>
			{showReadme =>
				showReadme &&
				(props => (
					<DialogOverlay
						container={document.querySelector('#wpbody')}
						style={{ opacity: props.opacity }}
						onDismiss={() => setIsShowingReadme(false)}>
						<DialogContent
							style={{
								transform: `translate3d(0px, ${props.y}px, 0px)`
							}}>
							<button
								className="close-button"
								onClick={() => setIsShowingReadme(false)}>
								×
							</button>
							<div
								className="ct-extension-readme"
								dangerouslySetInnerHTML={{
									__html: extension.readme
								}}
							/>
						</DialogContent>
					</DialogOverlay>
				))
			}
		</Transition>
	]
}

export default useExtensionReadme
