<?php

/**
 * @package     Maera/Widget/Class
 * @version     1.0.0
 * @author      Aristeides Stathopoulos, Brian Welch
 * @copyright   2014
 * @link        https://press.codes
 * @license     http://opensource.org/licenses/MIT
 */

class Maera_Logo_Widget extends WP_Widget {


	/**
	 * Add the widget to the back end.
	 * @todo TODO
	 * @since 1.0.0
	 */
	function __construct() {
		global $maera_i18n;
		parent::__construct(
			'maera_logo_widget',
			$maera_i18n['maeralogo'],
			array( 'description' => $maera_i18n['maeralogowidget'], )
		);
	}


	/**
	 * Render the widget on the back end.
	 * @todo TODO
	 * @since 1.0.0
	 */
	function form( $instance ) {
		?>
		<p class="label"><?php _e( 'This widget has no options to set', 'maera' )?></p>
		<?php
	}


	/**
	 * Render the widget on the front end.
	 * @todo TODO
	 * @since 1.0.0
	 */
	public function widget( $args, $instance ) {

		$context = Timber::get_context();
		Timber::render(
			array(
				'site-logo.twig',
			),
			$context,
			apply_filters( 'maera/timber/cache', false )
		);
	}


	/**
	 * Widget instance update.
	 * @todo TODO
	 * @since 1.0.0
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}

}