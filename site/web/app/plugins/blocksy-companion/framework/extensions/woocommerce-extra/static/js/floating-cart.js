export const mountFloatingCart = () => {
	var floatingCart = document.querySelector('.ct-floating-bar')

	if (!floatingCart) return

	// browser window scroll (in pixels) after which the "back to top" link is shown
	// browser window scroll (in pixels) after which the "back to top" link opacity is reduced
	var scrolling = false

	const compute = () => {
		var floatingCart = document.querySelector('.ct-floating-bar')

		const summary = (
			document.querySelector('.entry-summary') ||
			document.querySelector(
				'.woocommerce-product-details__short-description'
			)
		).getBoundingClientRect()

		if (!floatingCart) return

		window.scrollY > window.scrollY + summary.top + summary.height
			? floatingCart.classList.add('ct-active')
			: floatingCart.classList.remove('ct-active')
	}

	compute()

	window.addEventListener('scroll', () => {
		if (scrolling) return

		scrolling = true

		requestAnimationFrame(() => {
			compute()
			scrolling = false
		})
	})

	const maybeButton = floatingCart.querySelector(
		'.button:not(.single_add_to_cart_button):not(.product_type_external)'
	)

	if (maybeButton) {
		maybeButton.addEventListener('click', event => {
			event.preventDefault()

			var start = window.scrollY
			var currentTime = null

			const animateScroll = timestamp => {
				if (!currentTime) currentTime = timestamp
				var progress = timestamp - currentTime

				const easeInOutQuad = (t, b, c, d) => {
					t /= d / 2
					if (t < 1) return (c / 2) * t * t + b
					t--
					return (-c / 2) * (t * (t - 2) - 1) + b
				}

				const summary = (
					document.querySelector('.entry-summary') ||
					document.querySelector(
						'.woocommerce-product-details__short-description'
					)
				).getBoundingClientRect()

				var val = Math.max(
					easeInOutQuad(progress, start, -start, 700),
					window.scrollY + summary.top
				)

				scrollTo(0, val)

				if (progress < 700) {
					requestAnimationFrame(animateScroll)
				}
			}

			requestAnimationFrame(animateScroll)
		})
	}
}
