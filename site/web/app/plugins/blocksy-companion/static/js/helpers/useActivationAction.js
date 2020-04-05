import {
	createElement,
	Component,
	useEffect,
	useState,
	Fragment
} from '@wordpress/element'

const useActivationAction = (extension, cb = () => {}) => {
	const [isLoading, setIsLoading] = useState(false)

	const makeAction = async () => {
		const body = new FormData()

		body.append('ext', extension.name)
		body.append(
			'action',
			extension.__object
				? 'blocksy_extension_deactivate'
				: 'blocksy_extension_activate'
		)

		setIsLoading(true)

		try {
			await fetch(ctDashboardLocalizations.ajax_url, {
				method: 'POST',
				body
			})

			cb()
		} catch (e) {}

		// await new Promise(r => setTimeout(() => r(), 1000))

		setIsLoading(false)
	}

	return [isLoading, makeAction]
}

export default useActivationAction
