<?php
/**
 * Plugin Name: Beachhouse Room Tabs
 * Description: Beheer 4 kamerfoto's via een menu in het WordPress-dashboard en toon ze op je site als één grote foto die wisselt zodra een bezoeker over de kamernaam beweegt of klikt. Gebruik de shortcode [beachhouse_room_tabs].
 * Version: 1.0.0
 * Author: Beachhouse Costa Blanca
 * Text Domain: beachhouse-room-tabs
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'BRT_VERSION', '1.0.0' );
define( 'BRT_OPTION_KEY', 'beachhouse_room_tabs_options' );
define( 'BRT_SETTINGS_GROUP', 'beachhouse_room_tabs_group' );
define( 'BRT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'BRT_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

function brt_default_rooms() {
	return array(
		'ingang'    => array(
			'label'    => 'Ingang',
			'image_id' => 0,
		),
		'woonkamer' => array(
			'label'    => 'Woonkamer',
			'image_id' => 0,
		),
		'keuken'    => array(
			'label'    => 'Keuken',
			'image_id' => 0,
		),
		'dakterras' => array(
			'label'    => 'Dakterras',
			'image_id' => 0,
		),
	);
}

function brt_get_rooms() {
	$saved = get_option( BRT_OPTION_KEY, array() );
	$rooms = brt_default_rooms();

	foreach ( $rooms as $key => $defaults ) {
		if ( isset( $saved[ $key ] ) ) {
			$rooms[ $key ]['label']    = isset( $saved[ $key ]['label'] ) && '' !== $saved[ $key ]['label']
				? $saved[ $key ]['label']
				: $defaults['label'];
			$rooms[ $key ]['image_id'] = isset( $saved[ $key ]['image_id'] ) ? absint( $saved[ $key ]['image_id'] ) : 0;
		}
	}

	return $rooms;
}

/* ---------------------------------------------------------------------- */
/* Admin: menu-item in de WordPress-zijbalk met 4 tabs                    */
/* ---------------------------------------------------------------------- */

add_action( 'admin_menu', 'brt_admin_menu' );
function brt_admin_menu() {
	add_menu_page(
		'Kamer Tabs',
		'Kamer Tabs',
		'manage_options',
		'beachhouse-room-tabs',
		'brt_render_admin_page',
		'dashicons-format-gallery',
		58
	);
}

add_action( 'admin_init', 'brt_register_settings' );
function brt_register_settings() {
	register_setting( BRT_SETTINGS_GROUP, BRT_OPTION_KEY, 'brt_sanitize_settings' );
}

function brt_sanitize_settings( $input ) {
	$clean = array();

	foreach ( brt_default_rooms() as $key => $defaults ) {
		$clean[ $key ] = array(
			'label'    => isset( $input[ $key ]['label'] ) ? sanitize_text_field( $input[ $key ]['label'] ) : $defaults['label'],
			'image_id' => isset( $input[ $key ]['image_id'] ) ? absint( $input[ $key ]['image_id'] ) : 0,
		);
	}

	return $clean;
}

add_action( 'admin_enqueue_scripts', 'brt_admin_assets' );
function brt_admin_assets( $hook ) {
	if ( 'toplevel_page_beachhouse-room-tabs' !== $hook ) {
		return;
	}

	wp_enqueue_media();
	wp_enqueue_style( 'brt-admin', BRT_PLUGIN_URL . 'assets/admin.css', array(), BRT_VERSION );
	wp_enqueue_script( 'brt-admin', BRT_PLUGIN_URL . 'assets/admin.js', array( 'jquery' ), BRT_VERSION, true );
}

function brt_render_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$rooms = brt_get_rooms();
	$first = true;
	?>
	<div class="wrap brt-admin-wrap">
		<h1>Kamer Tabs &ndash; foto's</h1>
		<p>
			Upload hieronder de 4 foto's, één per tab. Plaats daarna de shortcode
			<code>[beachhouse_room_tabs]</code> op de pagina waar de galerij moet verschijnen.
			Bezoekers zien één grote foto; zodra ze over een naam bewegen of erop klikken, wisselt de foto.
		</p>
		<form method="post" action="options.php">
			<?php settings_fields( BRT_SETTINGS_GROUP ); ?>
			<div class="brt-admin-tabs">
				<div class="brt-admin-tabnav">
					<?php
					foreach ( $rooms as $key => $room ) :
						?>
						<button type="button" class="brt-admin-tabbtn<?php echo $first ? ' active' : ''; ?>" data-tab="<?php echo esc_attr( $key ); ?>">
							<?php echo esc_html( $room['label'] ); ?>
						</button>
						<?php
						$first = false;
					endforeach;
					?>
				</div>
				<div class="brt-admin-tabpanels">
					<?php
					$first = true;
					foreach ( $rooms as $key => $room ) :
						$image_url = $room['image_id'] ? wp_get_attachment_image_url( $room['image_id'], 'medium' ) : '';
						?>
						<div class="brt-admin-tabpanel<?php echo $first ? ' active' : ''; ?>" data-tab="<?php echo esc_attr( $key ); ?>">
							<table class="form-table" role="presentation">
								<tr>
									<th scope="row"><label for="brt-label-<?php echo esc_attr( $key ); ?>">Naam op de tab</label></th>
									<td>
										<input type="text" id="brt-label-<?php echo esc_attr( $key ); ?>"
											name="<?php echo esc_attr( BRT_OPTION_KEY ); ?>[<?php echo esc_attr( $key ); ?>][label]"
											value="<?php echo esc_attr( $room['label'] ); ?>" class="regular-text">
									</td>
								</tr>
								<tr>
									<th scope="row">Foto</th>
									<td>
										<div class="brt-image-picker">
											<img src="<?php echo esc_url( $image_url ); ?>" class="brt-preview" style="<?php echo $image_url ? '' : 'display:none;'; ?>" alt="">
											<div class="brt-preview-placeholder" style="<?php echo $image_url ? 'display:none;' : ''; ?>">Nog geen foto gekozen</div>
											<input type="hidden" class="brt-image-id"
												name="<?php echo esc_attr( BRT_OPTION_KEY ); ?>[<?php echo esc_attr( $key ); ?>][image_id]"
												value="<?php echo esc_attr( $room['image_id'] ); ?>">
											<p>
												<button type="button" class="button brt-choose-image">Kies foto</button>
												<button type="button" class="button brt-remove-image" style="<?php echo $image_url ? '' : 'display:none;'; ?>">Verwijderen</button>
											</p>
										</div>
									</td>
								</tr>
							</table>
						</div>
						<?php
						$first = false;
					endforeach;
					?>
				</div>
			</div>
			<?php submit_button( 'Wijzigingen opslaan' ); ?>
		</form>
	</div>
	<?php
}

/* ---------------------------------------------------------------------- */
/* Frontend: shortcode [beachhouse_room_tabs]                             */
/* ---------------------------------------------------------------------- */

add_shortcode( 'beachhouse_room_tabs', 'brt_render_shortcode' );
function brt_render_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'height' => '600',
		),
		$atts,
		'beachhouse_room_tabs'
	);

	$rooms = brt_get_rooms();

	wp_enqueue_style( 'brt-frontend', BRT_PLUGIN_URL . 'assets/frontend.css', array(), BRT_VERSION );
	wp_enqueue_script( 'brt-frontend', BRT_PLUGIN_URL . 'assets/frontend.js', array(), BRT_VERSION, true );

	ob_start();
	?>
	<div class="brt-wrap" style="--brt-height: <?php echo esc_attr( absint( $atts['height'] ) ); ?>px;">
		<nav class="brt-tabs" role="tablist">
			<?php
			$first = true;
			foreach ( $rooms as $key => $room ) :
				?>
				<button type="button" class="brt-tab<?php echo $first ? ' active' : ''; ?>" data-room="<?php echo esc_attr( $key ); ?>" role="tab" aria-selected="<?php echo $first ? 'true' : 'false'; ?>">
					<?php echo esc_html( $room['label'] ); ?>
				</button>
				<?php
				$first = false;
			endforeach;
			?>
		</nav>
		<div class="brt-stage">
			<?php
			$first     = true;
			$has_image = false;
			foreach ( $rooms as $key => $room ) :
				if ( ! $room['image_id'] ) {
					continue;
				}
				$has_image = true;
				echo wp_get_attachment_image(
					$room['image_id'],
					'large',
					false,
					array(
						'class'     => 'brt-image' . ( $first ? ' active' : '' ),
						'data-room' => $key,
						'alt'       => $room['label'],
					)
				);
				$first = false;
			endforeach;
			if ( ! $has_image ) :
				?>
				<p class="brt-empty">Nog geen foto's ingesteld. Ga naar <em>Kamer Tabs</em> in het WordPress-menu om foto's toe te voegen.</p>
				<?php
			endif;
			?>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
