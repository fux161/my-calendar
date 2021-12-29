<?php
/**
 * Custom KSES to allow some otherwise excluded attributes.
 *
 * @category Utilities
 * @package  My Calendar
 * @author   Joe Dolson
 * @license  GPLv2 or later
 * @link     https://www.joedolson.com/my-calendar/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Execute KSES post on strings, otherwise, return as is.
 *
 * @param string $string Any string.
 *
 * @return Value passed or cleaned string
 */
function mc_kses_post( $string ) {
	if ( ! is_string( $string ) ) {
		return $string;
	} else {
		return wp_kses( $string, 'mycalendar' );
	}
}

add_filter( 'wp_kses_allowed_html', 'mc_allowed_tags', 10, 2 );
/**
 * My Calendar needs to allow input and select in posts and a variety of other key elements; also provide support for schema.org data.
 * Call using wp_kses( $data, 'mycalendar' );
 *
 * @param array  $tags Original allowed tags.
 * @param string $context Custom context for My Calendar to avoid running elsewhere.
 *
 * @return return array tags
 */
function mc_allowed_tags( $tags, $context ) {
	if ( 'mycalendar' === $context ) {
		global $allowedposttags;
		$tags = $allowedposttags;

		if ( current_user_can( 'unfiltered_html' ) ) {
			$tags['input'] = array(
				'type'             => true,
				'value'            => true,
				'name'             => true,
				'class'            => true,
				'aria-labelledby'  => true,
				'aria-describedby' => true,
				'disabled'         => true,
				'readonly'         => true,
				'min'              => true,
				'max'              => true,
				'id'               => true,
				'checked'          => true,
				'required'         => true,
				'data-href'        => true,
			);

			$tags['select'] = array(
				'name'  => true,
				'id'    => true,
				'class' => true,
			);

			$tags['option'] = array(
				'value' => true,
			);

			$formtags     = ( isset( $tags['form'] ) && is_array( $tags['form'] ) ) ? $tags['form'] : array();
			$tags['form'] = array_merge(
				$formtags,
				array(
					'action' => true,
					'method' => true,
					'class'  => true,
					'id'     => true,
				)
			);
		}

		$tags['button'] = array_merge(
			$tags['button'],
			array(
				'name'     => true,
				'type'     => true,
				'disabled' => true,
				'class'    => true,
			)
		);

		$tags['div'] = array_merge(
			$tags['div'],
			array(
				'class'     => true,
				'id'        => true,
				'aria-live' => true,
			)
		);

		$tags['fieldset'] = array_merge( $tags['fieldset'], array() );
		$tags['legend']   = array_merge( $tags['legend'], array() );
		$tags['p']        = array_merge(
			$tags['p'],
			array(
				'class' => true,
			)
		);

		$tags['img'] = array_merge(
			$tags['img'],
			array(
				'class'    => true,
				'src'      => true,
				'alt'      => true,
				'width'    => true,
				'height'   => true,
				'id'       => true,
				'longdesc' => true,
				'tabindex' => true,
			)
		);

		$tags['iframe'] = array(
			'width'       => true,
			'height'      => true,
			'src'         => true,
			'frameborder' => true,
			'title'       => true,
		);

		$tags['th'] = array(
			'aria-sort' => true,
		);

		$tags['a'] = array(
			'aria-labelledby'  => true,
			'aria-describedby' => true,
			'href'             => true,
			'class'            => true,
			'target'           => true,
		);

		$tags['script'] = array(
			'type' => 'application/ld+json',
		);
	}

	return apply_filters( 'mc_kses_post', $tags );
}

/**
 * Array of allowed elements for using KSES on forms.
 *
 * @return array
 */
function mc_kses_elements() {
	$elements = array(
		'svg'              => array(
			'class'           => array(),
			'style'           => array(),
			'focusable'       => array(),
			'role'            => array(),
			'aria-labelledby' => array(),
			'xmlns'           => array(),
			'viewbox'         => array(),
		),
		'g'                => array(
			'fill' => array(),
		),
		'title'            => array(
			'id'    => array(),
			'title' => array(),
		),
		'path'             => array(
			'd'    => array(),
			'fill' => array(),
		),
		'h2'               => array(
			'class' => array(),
			'id'    => array(),
		),
		'h3'               => array(
			'class' => array(),
			'id'    => array(),
		),
		'h4'               => array(
			'class' => array(),
			'id'    => array(),
		),
		'h5'               => array(
			'class' => array(),
			'id'    => array(),
		),
		'h6'               => array(
			'class' => array(),
			'id'    => array(),
		),
		'label'            => array(
			'for'   => array(),
			'class' => array(),
		),
		'option'           => array(
			'value'    => array(),
			'selected' => array(),
		),
		'select'           => array(
			'id'               => array(),
			'aria-describedby' => array(),
			'aria-labelledby'  => array(),
			'name'             => array(),
			'disabled'         => array(),
			'min'              => array(),
			'max'              => array(),
			'required'         => array(),
			'readonly'         => array(),
			'autocomplete'     => array(),
		),
		'input'            => array(
			'id'               => array(),
			'class'            => array(),
			'aria-describedby' => array(),
			'aria-labelledby'  => array(),
			'value'            => array(),
			'type'             => array(),
			'name'             => array(),
			'size'             => array(),
			'checked'          => array(),
			'disabled'         => array(),
			'min'              => array(),
			'max'              => array(),
			'required'         => array(),
			'readonly'         => array(),
			'autocomplete'     => array(),
			'data-href'        => array(),
		),
		'textarea'         => array(
			'id'               => array(),
			'class'            => array(),
			'cols'             => array(),
			'rows'             => array(),
			'aria-describedby' => array(),
			'aria-labelledby'  => array(),
			'disabled'         => array(),
			'required'         => array(),
			'readonly'         => array(),
			'name'             => array(),
		),
		'form'             => array(
			'id'     => array(),
			'name'   => array(),
			'action' => array(),
			'method' => array(),
			'class'  => array(),
		),
		'button'           => array(
			'name'             => array(),
			'disabled'         => array(),
			'type'             => array(),
			'class'            => array(),
			'aria-expanded'    => array(),
			'aria-describedby' => array(),
			'role'             => array(),
			'aria-selected'    => array(),
			'aria-controls'    => array(),
			'data-href'        => array(),
		),
		'ul'               => array(
			'class' => array(),
		),
		'fieldset'         => array(
			'class' => array(),
			'id'    => array(),
		),
		'legend'           => array(
			'class' => array(),
			'id'    => array(),
		),
		'li'               => array(
			'class' => array(),
		),
		'span'             => array(
			'id'          => array(),
			'class'       => array(),
			'aria-live'   => array(),
			'aria-hidden' => array(),
			'span'        => array(),
		),
		'i'                => array(
			'id'          => array(),
			'class'       => array(),
			'aria-live'   => array(),
			'aria-hidden' => array(),
		),
		'p'                => array(
			'class' => array(),
		),
		'div'              => array(
			'class'           => array(),
			'aria-live'       => array(),
			'id'              => array(),
			'role'            => array(),
			'data-default'    => array(),
			'aria-labelledby' => array(),
			'style'           => array(),
		),
		'img'              => array(
			'class'    => true,
			'src'      => true,
			'alt'      => true,
			'width'    => true,
			'height'   => true,
			'id'       => true,
			'longdesc' => true,
			'tabindex' => true,
		),
		'br'               => array(),
		'table'            => array(
			'class' => array(),
			'id'    => array(),
		),
		'caption'          => array(),
		'thead'            => array(),
		'tfoot'            => array(),
		'tbody'            => array(),
		'tr'               => array(
			'class' => array(),
			'id'    => array(),
		),
		'th'               => array(
			'scope' => array(),
			'class' => array(),
			'id'    => array(),
		),
		'td'               => array(
			'class'     => array(),
			'id'        => array(),
			'aria-live' => array(),
		),
		'a'                => array(
			'aria-labelledby'  => array(),
			'aria-describedby' => array(),
			'href'             => array(),
			'class'            => array(),
			'aria-current'     => array(),
		),
		'section'          => array(
			'id'    => array(),
			'class' => array(),
		),
		'aside'            => array(
			'id'    => array(),
			'class' => array(),
		),
		'code'             => array(
			'class' => array(),
		),
		'pre'              => array(
			'class' => array(),
		),
		'script'           => array(
			'type' => 'application/ld+json',
		),
		'duet-date-picker' => array(
			'identifier'        => array(),
			'first-day-of-week' => array(),
			'name'              => array(),
			'value'             => array(),
			'required'          => array(),
		),
	);

	return $elements;
}
