<?php
/**
 * Plugins section template.
 *
 * @since 3.17.2
 */

defined( 'ABSPATH' ) || exit;
?>

<div id="plugins" class="wpr-Page">
	<div class="wpr-sectionHeader">
		<h2 class="wpr-title1 wpr-icons-plugins-hover"><?php esc_html_e( 'Our Plugins', 'rocket' ); ?></h2>
	</div>
	<div class="wpr-field-description">
		<?php
		esc_html_e( 'Beyond WP Rocket, there\'s a whole family of plugins designed to help you build better, faster, and safer websites. Each one is crafted with our unique blend of expertise, simplicity, and outstanding support.', 'rocket' );
		?>
		<br><br>
		<?php
		esc_html_e( 'Combine our plugins below to build incredible WordPress websites!', 'rocket' );
		?>
	</div>
		<?php
		if ( ! empty( $data ) ) :
			foreach ( $data as $key => $category ) : // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
				?>
				<div class="wpr-optionHeader">
					<h3 class="wpr-title2"><?php echo esc_html( $category['title'] ); ?></h3>
				</div>
				<div class="wpr-Page-row">
					<?php foreach ( $category['plugins'] as $index => $wpm_plugin ) : // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound ?>
					<div class="wpr-Page-col">
						<h4 class="wpr-fieldsContainer-description">
							<?php echo esc_html( $wpm_plugin['title'] ); ?>
						</h4>
						<p>
							<?php echo esc_html( $wpm_plugin['desc'] ); ?>
						</p>
						<div class="meta">
							<a href="<?php echo esc_html( $wpm_plugin['cta']['url'] ); ?>">
								<?php echo esc_html( $wpm_plugin['cta']['text'] ); ?>
							</a>

							<a href="<?php echo esc_html( $wpm_plugin['link'] ); ?>">
								<?php esc_html_e( 'Learn More', 'rocket' ); ?>
							</a>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
				<?php
			endforeach;
		endif
		?>
	</div>

