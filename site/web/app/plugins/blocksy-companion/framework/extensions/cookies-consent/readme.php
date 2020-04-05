<h1><?php echo __('Instructions', 'blc'); ?></h1>

<p>
	<?php echo __('After installing and activating the Cookies Consent extension you will be able to configure it from this location:', 'blc') ?>
</p>

<ul>
	<li>
		<h4><?php echo __('Customizer', 'blc') ?></h4>
		<i>
		<?php
			echo sprintf(
				__('Navigate to %s and customize the notification to meet your needs.', 'blc'),
				sprintf(
					'<code>%s</code>',
					__('Customizer ➝ Cookie Consent', 'blc')
				)
			);
		?>
		</i>
	</li>
</ul>

<div class="extension-notice">
	<h3><?php echo __('W3 Total Cache Support', 'blc'); ?></h3>

	<p>
		<?php echo __('If you encounter problems with W3 Total Cache plugin, please follow these steps:', 'blc') ?>
	</p>

	<ol>
		<li>
			<?php
				echo sprintf(
					__('Navigate to %sPerformance ➝ Page Cache%s and scroll to the %sRejected cookies%s option.', 'blc'),
					'<code>', '</code>',
					'<b>', '</b>'
				);
			?>
		</li>

		<li>
			<?php
				echo sprintf(
					__('In the text field there, insert this value: %sblocksy_cookies_consent_accepted%s.', 'blc'),
					'<code>', '</code>'
				);
			?>
		</li>

		<li>
			<?php
				echo __('Make sure to purge all caches from settings.', 'blc')
			?>
		</li>
	</ol>

	<div class="notice-divider"></div>

	<h3><?php echo __('WP Fastest Cache Support', 'blc'); ?></h3>

	<p>
		<?php echo __('If you encounter problems with WP Fastest Cache plugin, please follow these steps:', 'blc') ?>
	</p>

	<ol>
		<li>
			<?php
				echo sprintf(
					__('Navigate to %sExclude%s and scroll to the %sExclude Cookies%s option.', 'blc'),
					'<code>', '</code>',
					'<b>', '</b>'
				);
			?>
		</li>

		<li>
			<?php
				echo sprintf(
					__('Click on Add new rule and insert this value: %sblocksy_cookies_consent_accepted%s.', 'blc'),
					'<code>', '</code>'
				);
			?>
		</li>

		<li>
			<?php
				echo __('Make sure to purge all caches from settings.', 'blc')
			?>
		</li>
	</ol>
</div>
