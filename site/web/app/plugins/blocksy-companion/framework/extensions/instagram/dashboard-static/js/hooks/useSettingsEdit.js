import {
	createElement,
	Component,
	useEffect,
	useState,
	Fragment
} from '@wordpress/element'

import { Transition } from 'react-spring/renderprops'
import EditCredentials from '../EditCredentials'

const useSettingsEdit = (extension, cb = () => {}) => {
	const [isLoading, setIsLoading] = useState(false)
	const [isEditing, setIsEditing] = useState(false)

	const handleActionWithRequirements = () => {
		if (extension.__object || extension.data.api_key) {
			toggleActivationState()
			return
		}

		setIsEditingCredentials(true)
	}

	return <Fragment>
			{extension.__object &&
				extension.data.api_key && (
					<button
						className="ct-minimal-button ct-config-btn dashicons dashicons-admin-generic"
						title="Edit Credentials"
						onClick={() => setIsEditingCredentials(true)}
					/>
				)}

			<EditCredentials
				isEditingCredentials={isEditingCredentials}
				setIsEditingCredentials={setIsEditingCredentials}
				extension={extension}
				onCredentialsValidated={() => {
					if (!extension.__object) {
						toggleActivationState()
					}

					setIsEditingCredentials(false)
				}}
			/>
		</Fragment>
}

export default useSettingsEdit
