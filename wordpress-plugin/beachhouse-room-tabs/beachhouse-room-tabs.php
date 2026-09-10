<?php
/**
 * Plugin Name: Beachhouse Room Tabs
 * Description: Beheer 4 losse foto-tabs in de WordPress-zijbalk (Ingang, Woonkamer, Keuken, Dakterras) en toon ze op je site als één grote foto die wisselt zodra een bezoeker over de kamernaam beweegt of klikt. Gebruik de shortcode [beachhouse_room_tabs].
 * Version: 1.1.0
 * Author: Beachhouse Costa Blanca
 * Text Domain: beachhouse-room-tabs
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'BRT_VERSION', '1.1.0' );
define( 'BRT_OPTION_KEY', 'beachhouse_room_tabs_options' );
define( 'BRT_HEADING_OPTION_KEY', 'beachhouse_room_tabs_heading' );
define( 'BRT_SETTINGS_GROUP', 'beachhouse_room_tabs_group' );
define( 'BRT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'BRT_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

function brt_default_heading() {
	return array(
		'subtitle' => 'NEEM EEN KIJKJE',
		'title'    => 'In Beachhouse Sueños del Mar',
	);
}

function brt_get_heading() {
	$saved   = get_option( BRT_HEADING_OPTION_KEY, array() );
	$heading = brt_default_heading();

	if ( isset( $saved['subtitle'] ) && '' !== $saved['subtitle'] ) {
		$heading['subtitle'] = $saved['subtitle'];
	}
	if ( isset( $saved['title'] ) && '' !== $saved['title'] ) {
		$heading['title'] = $saved['title'];
	}

	return $heading;
}

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
/* Admin: 4 losse tabs (submenu's) in de WordPress-zijbalk, één per kamer */
/* ---------------------------------------------------------------------- */

add_action( 'admin_menu', 'brt_admin_menu' );
function brt_admin_menu() {
	global $brt_admin_hooks;
	$brt_admin_hooks = array();

	$brt_admin_hooks[] = add_menu_page(
		'Kamer Tabs',
		'Kamer Tabs',
		'manage_options',
		'beachhouse-room-tabs',
		'brt_render_overview_page',
		'dashicons-format-gallery',
		58
	);

	// Hernoem het automatisch aangemaakte eerste submenu-item.
	$brt_admin_hooks[] = add_submenu_page(
		'beachhouse-room-tabs',
		'Kamer Tabs – overzicht',
		'Overzicht',
		'manage_options',
		'beachhouse-room-tabs',
		'brt_render_overview_page'
	);

	// Eén losse tab per kamer, elk met een eigen foto-upload.
	foreach ( brt_get_rooms() as $key => $room ) {
		$brt_admin_hooks[] = add_submenu_page(
			'beachhouse-room-tabs',
			$room['label'],
			$room['label'],
			'manage_options',
			'beachhouse-room-tabs-' . $key,
			function () use ( $key ) {
				brt_render_room_page( $key );
			}
		);
	}
}

add_action( 'admin_init', 'brt_register_settings' );
function brt_register_settings() {
	register_setting( BRT_SETTINGS_GROUP, BRT_OPTION_KEY, 'brt_sanitize_settings' );
	register_setting( BRT_SETTINGS_GROUP, BRT_HEADING_OPTION_KEY, 'brt_sanitize_heading' );
}

function brt_sanitize_settings( $input ) {
	// Elke tab stuurt maar het formulier van zijn eigen kamer op, dus
	// bestaande waarden van de andere kamers blijven behouden.
	$existing = get_option( BRT_OPTION_KEY, array() );
	$clean    = array();

	foreach ( brt_default_rooms() as $key => $defaults ) {
		if ( isset( $input[ $key ] ) ) {
			$clean[ $key ] = array(
				'label'    => isset( $input[ $key ]['label'] ) && '' !== $input[ $key ]['label']
					? sanitize_text_field( $input[ $key ]['label'] )
					: $defaults['label'],
				'image_id' => isset( $input[ $key ]['image_id'] ) ? absint( $input[ $key ]['image_id'] ) : 0,
			);
		} elseif ( isset( $existing[ $key ] ) ) {
			$clean[ $key ] = array(
				'label'    => isset( $existing[ $key ]['label'] ) ? sanitize_text_field( $existing[ $key ]['label'] ) : $defaults['label'],
				'image_id' => isset( $existing[ $key ]['image_id'] ) ? absint( $existing[ $key ]['image_id'] ) : 0,
			);
		} else {
			$clean[ $key ] = $defaults;
		}
	}

	return $clean;
}

function brt_sanitize_heading( $input ) {
	$defaults = brt_default_heading();

	return array(
		'subtitle' => isset( $input['subtitle'] ) ? sanitize_text_field( $input['subtitle'] ) : $defaults['subtitle'],
		'title'    => isset( $input['title'] ) ? sanitize_text_field( $input['title'] ) : $defaults['title'],
	);
}

add_action( 'admin_enqueue_scripts', 'brt_admin_assets' );
function brt_admin_assets( $hook ) {
	global $brt_admin_hooks;

	if ( empty( $brt_admin_hooks ) || ! in_array( $hook, $brt_admin_hooks, true ) ) {
		return;
	}

	wp_enqueue_media();
	wp_enqueue_style( 'brt-admin', BRT_PLUGIN_URL . 'assets/admin.css', array(), BRT_VERSION );
	wp_enqueue_script( 'brt-admin', BRT_PLUGIN_URL . 'assets/admin.js', array( 'jquery' ), BRT_VERSION, true );
}

function brt_render_overview_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$rooms   = brt_get_rooms();
	$heading = brt_get_heading();
	?>
	<div class="wrap brt-admin-wrap">
		<h1>Kamer Tabs</h1>
		<p>
			Deze galerij toont op je website één grote foto die wisselt zodra een bezoeker over
			een kamernaam beweegt of erop klikt. Klik hiernaast op één van de 4 losse tabs
			(<?php echo esc_html( implode( ', ', wp_list_pluck( $rooms, 'label' ) ) ); ?>) om de foto van die kamer te uploaden.
		</p>

		<h2>Kop boven de galerij</h2>
		<form method="post" action="options.php">
			<?php settings_fields( BRT_SETTINGS_GROUP ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="brt-subtitle">Bijschrift</label></th>
					<td>
						<input type="text" id="brt-subtitle"
							name="<?php echo esc_attr( BRT_HEADING_OPTION_KEY ); ?>[subtitle]"
							value="<?php echo esc_attr( $heading['subtitle'] ); ?>" class="regular-text">
						<p class="description">Bijv. "NEEM EEN KIJKJE"</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="brt-title">Titel</label></th>
					<td>
						<input type="text" id="brt-title"
							name="<?php echo esc_attr( BRT_HEADING_OPTION_KEY ); ?>[title]"
							value="<?php echo esc_attr( $heading['title'] ); ?>" class="regular-text">
						<p class="description">Bijv. "In Beachhouse Sueños del Mar"</p>
					</td>
				</tr>
			</table>
			<?php submit_button( 'Wijzigingen opslaan' ); ?>
		</form>

		<h2>Kamers</h2>
		<div class="brt-overview-grid">
			<?php foreach ( $rooms as $key => $room ) :
				$image_url = $room['image_id'] ? wp_get_attachment_image_url( $room['image_id'], 'medium' ) : '';
				?>
				<a class="brt-overview-card" href="<?php echo esc_url( admin_url( 'admin.php?page=beachhouse-room-tabs-' . $key ) ); ?>">
					<?php if ( $image_url ) : ?>
						<img src="<?php echo esc_url( $image_url ); ?>" alt="">
					<?php else : ?>
						<span class="brt-overview-empty">Nog geen foto</span>
					<?php endif; ?>
					<span class="brt-overview-label"><?php echo esc_html( $room['label'] ); ?></span>
				</a>
			<?php endforeach; ?>
		</div>

		<h2>Shortcode</h2>
		<p>Plaats deze shortcode op de pagina waar de galerij moet verschijnen:</p>
		<p><code>[beachhouse_room_tabs]</code></p>
	</div>
	<?php
}

function brt_render_room_page( $room_key ) {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$all_rooms = brt_get_rooms();
	if ( ! isset( $all_rooms[ $room_key ] ) ) {
		return;
	}

	$room      = $all_rooms[ $room_key ];
	$image_url = $room['image_id'] ? wp_get_attachment_image_url( $room['image_id'], 'medium' ) : '';
	?>
	<div class="wrap brt-admin-wrap">
		<h1><?php echo esc_html( $room['label'] ); ?></h1>
		<p>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=beachhouse-room-tabs' ) ); ?>">&larr; Terug naar overzicht</a>
		</p>
		<form method="post" action="options.php">
			<?php settings_fields( BRT_SETTINGS_GROUP ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="brt-label-<?php echo esc_attr( $room_key ); ?>">Naam op de tab</label></th>
					<td>
						<input type="text" id="brt-label-<?php echo esc_attr( $room_key ); ?>"
							name="<?php echo esc_attr( BRT_OPTION_KEY ); ?>[<?php echo esc_attr( $room_key ); ?>][label]"
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
								name="<?php echo esc_attr( BRT_OPTION_KEY ); ?>[<?php echo esc_attr( $room_key ); ?>][image_id]"
								value="<?php echo esc_attr( $room['image_id'] ); ?>">
							<p>
								<button type="button" class="button brt-choose-image">Kies foto</button>
								<button type="button" class="button brt-remove-image" style="<?php echo $image_url ? '' : 'display:none;'; ?>">Verwijderen</button>
							</p>
						</div>
					</td>
				</tr>
			</table>
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
			'height'   => '600',
			'title'    => '',
			'subtitle' => '',
		),
		$atts,
		'beachhouse_room_tabs'
	);

	$rooms   = brt_get_rooms();
	$heading = brt_get_heading();
	$title   = '' !== $atts['title'] ? $atts['title'] : $heading['title'];
	$subtitle = '' !== $atts['subtitle'] ? $atts['subtitle'] : $heading['subtitle'];

	wp_enqueue_style( 'brt-google-fonts', 'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@1,400;1,500&family=Jost:wght@400;500&display=swap', array(), null );
	wp_enqueue_style( 'brt-frontend', BRT_PLUGIN_URL . 'assets/frontend.css', array( 'brt-google-fonts' ), BRT_VERSION );
	wp_enqueue_script( 'brt-frontend', BRT_PLUGIN_URL . 'assets/frontend.js', array(), BRT_VERSION, true );

	ob_start();
	?>
	<div class="brt-wrap" style="--brt-height: <?php echo esc_attr( absint( $atts['height'] ) ); ?>px;">
		<?php if ( $subtitle || $title ) : ?>
			<div class="brt-heading">
				<?php if ( $subtitle ) : ?>
					<p class="brt-subtitle"><?php echo esc_html( $subtitle ); ?></p>
				<?php endif; ?>
				<?php if ( $title ) : ?>
					<h2 class="brt-title"><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>
			</div>
		<?php endif; ?>
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
