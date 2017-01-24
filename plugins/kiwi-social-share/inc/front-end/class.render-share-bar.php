<?php


class Kiwi_Render_Share_Bar extends Kiwi_Plugin_Utilities {

	public function __construct() {

		// add css / js for the front-end
		add_action( 'wp_enqueue_scripts', array( $this, 'front_end_register_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'front_end_register_scripts' ) );

		// hook our meta tag generator function to the header
		add_action( 'wp_head', array( $this, 'og_tags' ) );
		add_action( 'wp_footer', array( $this, 'svg_meta' ) );

		// render on the front
		add_action( 'the_content', array( $this, 'display_bar' ) );
	}

	public function front_end_register_styles() {

		wp_register_style( 'kiwi-front-end-style', KIWI__PLUGINS_URL . 'assets/front-end/css/front-end-styles.css', false, KIWI__PLUGIN_VERSION );
		wp_enqueue_style( 'kiwi-front-end-style' );
	}

	public function front_end_register_scripts() {

		wp_register_script( 'kiwi-front-end-scripts', KIWI__PLUGINS_URL . 'assets/front-end/js/front-end-scripts.js', array( 'jquery' ), KIWI__PLUGIN_VERSION, true );
		wp_enqueue_script( 'kiwi-front-end-scripts' );
	}

	/**
	 *
	 * We'll need to for the title of the posts
	 * Converts smart quotes
	 *
	 * @param $content
	 *
	 * @return mixed
	 */
	public function convert_smart_quotes( $content ) {

		$content = str_replace( '"', '\'', $content );
		$content = str_replace( '&#8220;', '\'', $content );
		$content = str_replace( '&#8221;', '\'', $content );
		$content = str_replace( '&#8216;', '\'', $content );
		$content = str_replace( '&#8217;', '\'', $content );


		return $content;
	}

	/**
	 *
	 * Filtering function for the_excerpt
	 * Strips shortcodes, extra tags and limits word count to 100
	 *
	 * @param $post_id
	 *
	 * @return mixed|string
	 */
	public function get_excerpt_by_id( $post_id ) {

		// Check if the post has an excerpt
		if ( has_excerpt() ) {

			$the_post    = get_post( $post_id ); //Gets post ID
			$the_excerpt = $the_post->post_excerpt; // Gets post excerpt

			// If not, let's create an excerpt
		} else {
			$the_post    = get_post( $post_id ); //Gets post ID
			$the_excerpt = $the_post->post_content; //Gets post_content to be used as a basis for the excerpt
		}

		$excerpt_length = 100; //Sets excerpt length by word count
		$the_excerpt    = strip_tags( strip_shortcodes( $the_excerpt ) ); //Strips tags, shortcodes and images

		$the_excerpt = str_replace( ']]>', ']]&gt;', $the_excerpt );


		$excerpt_length = apply_filters( 'excerpt_length', 100 );
		$excerpt_more   = apply_filters( 'excerpt_more', ' ' . '[...]' );

		$words = preg_split( "/[\n\r\t ]+/", $the_excerpt, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY );

		if ( count( $words ) > $excerpt_length ) {
			array_pop( $words );
			$the_excerpt = implode( ' ', $words );
		}

		$the_excerpt = preg_replace( "/\r|\n/", "", $the_excerpt ); // filter out carriage returns and new lines

		return $the_excerpt;
	}

	/**
	 *
	 * Function to get author ID by post ID
	 *
	 * @param int $post_id
	 *
	 * @return string
	 */
	public function get_author_id_by_post_id( $post_id = 0 ) {
		$post = get_post( $post_id );

		return $post->post_author;
	}

	/**
	 * Function for the display logic on the front-end of the Kiwi Share Bar
	 *
	 * @param $content
	 *
	 * @return string|void
	 */
	public function display_bar( $content ) {

		if ( is_singular() ) {

			// get enabled social networks
			$kiwi_display_fb          = parent::get_option_value( 'kiwi-enable-facebook' );
			$kiwi_display_twitter     = parent::get_option_value( 'kiwi-enable-twitter' );
			$kiwi_display_google_plus = parent::get_option_value( 'kiwi-enable-google-plus' );
			$kiwi_display_linkedin    = parent::get_option_value( 'kiwi-enable-linkedin' );
			$kiwi_display_pinterest   = parent::get_option_value( 'kiwi-enable-pinterest' );
			$kiwi_display_reddit      = parent::get_option_value( 'kiwi-enable-reddit' );
			$kiwi_display_mail        = parent::get_option_value( 'kiwi-enable-email' );

			// where to display
			$kiwi_display_on_posts = parent::get_option_value( 'kiwi-enable-on-posts' );
			$kiwi_display_on_pages = parent::get_option_value( 'kiwi-enable-on-pages' );

			// share position
			$kiwi_share_position = parent::get_option_value( 'kiwi-enable-share-position' );

			// share bar skin/layout
			$kiwi_skin = parent::get_option_value( 'kiwi-design-choose-layout' );
			$kiwi_size = parent::get_option_value( 'kiwi-display-sizes' );

			if ( ( $kiwi_display_on_posts == 1 && is_single() ) || ( $kiwi_display_on_pages == 1 && is_page() ) ) {

				// start building the output
				$output = '<div class="clear"></div>';
				$output .= '<ul class="kiwi-share-bar-wrapper ' . esc_attr( $kiwi_skin ) . ' ' . esc_attr( $kiwi_size ) . '">';

				// Facebook
				if ( $kiwi_display_fb == 1 ) {
					$output .= PHP_EOL . '<li class="kiwi-share-icon">';
					$output .= '<a data-class="popup" rel="nofollow" title="' . __( 'Share on Facebook', 'kiwi-social-share' ) . '" target="_blank" href="//www.facebook.com/sharer/sharer.php?u=' . get_the_permalink() . '" />';
					$output .= '<div class="kiwi-facebook-icon">';
					$output .= '<svg class="kiwi-facebook-svg">';
					$output .= '<use xlink:href="#facebook">';
					$output .= '</svg>';
					$output .= '</div>';
					$output .= '</a>';
					$output .= '</li><!--/.kiwi-fb-icon-->';
				}

				// Twitter
				if ( $kiwi_display_twitter == 1 ) {
					$output .= PHP_EOL . '<li class="kiwi-share-icon">';
					$output .= '<a data-class="popup" rel="nofollow" title="' . __( 'Share on Twitter', 'kiwi-social-share' ) . '" target="_blank" href="//twitter.com/intent/tweet?text=' . rawurlencode( get_the_title() ) . '&url=' . rawurlencode( get_the_permalink() ) . '" />';
					$output .= '<div class="kiwi-twitter-icon">';
					$output .= '<svg class="kiwi-twitter-svg">';
					$output .= '<use xlink:href="#twitter">';
					$output .= '</svg>';
					$output .= '</div>';
					$output .= '</a>';
					$output .= '</li><!--/.kiwi-twitter-icon-->';
				}

				// Google+
				if ( $kiwi_display_google_plus == 1 ) {
					$output .= PHP_EOL . '<li class="kiwi-share-icon">';
					$output .= '<a data-class="popup" rel="nofollow" target="_blank" href="//plus.google.com/share?url=' . rawurlencode( get_the_permalink() ) . '">';
					$output .= '<div class="kiwi-google-plus-icon">';
					$output .= '<svg class="kiwi-googleplus-svg">';
					$output .= '<use xlink:href="#googleplus">';
					$output .= '</svg>';
					$output .= '</div>';
					$output .= '</a>';
					$output .= '</li><!--/.kiwi-google-plus-icon-->';
				}


				// LinkedIN
				if ( $kiwi_display_linkedin == 1 ) {

					$output .= PHP_EOL . '<li class="kiwi-share-icon">';
					$output .= '<a data-class="popup" rel="nofollow" target="_blank" href="//linkedin.com/shareArticle?mini=true&url=' . rawurlencode( get_the_permalink() ) . '&title=' . rawurlencode( get_the_title() ) . '">';
					$output .= '<div class="kiwi-linkedin-icon">';
					$output .= '<svg class="kiwi-linkedin-svg">';
					$output .= '<use xlink:href="#linkedin">';
					$output .= '</svg>';
					$output .= '</div>';
					$output .= '</a>';
					$output .= '</li><!--/.kiwi-linkedin-icon-->';

				}

				// Pinterest
				if ( $kiwi_display_pinterest == 1 ) {

					$output .= PHP_EOL . '<li class="kiwi-share-icon">';
					$output .= '<a data-class="popup"  rel="nofollow" target="_blank" href="//pinterest.com/pin/create/button/?url=' . '&description=' . rawurlencode( $this->get_excerpt_by_id( absint( get_the_ID() ) ) ) . '&media=' . wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ) . '">';
					$output .= '<div class="kiwi-pinterest-icon">';
					$output .= '<svg class="kiwi-pinterest-svg">';
					$output .= '<use xlink:href="#pinterest">';
					$output .= '</svg>';
					$output .= '</div>';
					$output .= '</a>';
					$output .= '</li><!--/.kiwi-pinterest-icon-->';
				}

				// reddit
				if ( $kiwi_display_reddit == 1 ) {

					$output .= PHP_EOL . '<li class="kiwi-share-icon">';
					$output .= '<a data-class="popup" rel="nofollow" target="_blank" href="//reddit.com/submit?url=' . rawurlencode( get_the_permalink() ) . '">';
					$output .= '<div class="kiwi-reddit-icon">';
					$output .= '<svg class="kiwi-reddit-svg">';
					$output .= '<use xlink:href="#reddit">';
					$output .= '</svg>';
					$output .= '</div>';
					$output .= '</a>';
					$output .= '</li><!--/.kiwi-reddit-icon-->';
				}

				// Mail
				if ( $kiwi_display_mail == 1 ) {

					$output .= PHP_EOL . '<li class="kiwi-share-icon">';
					$output .= '<a data-class="popup" rel="nofollow" href="mailto:?subject=' . rawurlencode( get_the_title() ) . '&body=' . rawurlencode( get_the_permalink() ) . '">';
					$output .= '<div class="kiwi-email-icon">';
					$output .= '<svg class="kiwi-email-svg">';
					$output .= '<use xlink:href="#email">';
					$output .= '</svg>';
					$output .= '</div>';
					$output .= '</a>';
					$output .= '</li><!--/.kiwi-email-icon-->';
				}

				$output .= '</ul><!--/.kiwi-share-bar-wrapper-->';

				if ( $kiwi_share_position == 'before-posts' ) {
					$output .= $content;

					return $output;

				} elseif ( $kiwi_share_position == 'after-posts' ) {
					$content .= $output;

					return $content;
				} else if ( $kiwi_share_position == 'before_and_after_posts' ) {

					$share_bar = $output;

					$output .= $content;
					$output .= $share_bar;

					return $output;
				}

				return;
			} else{
				return $content; // if kiwi is disabled on posts or pages, return only the content;
			} // check if is_single || is_page
		} else {
			return $content;
		} // is_singular()
	}

	/**
	 * Function that echoes out the SVG icons we're using for the social buttons
	 */
	public function svg_meta() {

		echo '<svg class="svg-symbol">';

		echo PHP_EOL . '<symbol id="facebook" viewBox="0 0 15.2 32"><path d="M15.2,11.1H9.6V7c0-1.2,1.3-1.5,1.9-1.5c0.6,0,3.6,0,3.6,0V0L11,0C5.4,0,4.1,4.1,4.1,6.7v4.4H0v5.6h4.1
        c0,7.3,0,15.2,0,15.2h5.5c0,0,0-8.1,0-15.2h4.7L15.2,11.1z"></path></symbol>';

		echo PHP_EOL . '<symbol id="email" viewBox="0 0 32 21"><g><polygon points="32,19.5 32,1.3 23.1,10.4"></polygon></g><g><path d="M16.9,13.8L30.4,0h-29l13.5,13.9C15.4,14.4,16.3,14.4,16.9,13.8z"></path></g><g><polygon points="0,1.5 0,19.4 8.7,10.5"></polygon></g><g><path d="M18.3,15.3c-0.7,0.7-1.6,1-2.4,1c-0.9,0-1.7-0.3-2.4-1L10.2,12l-8.8,9h29.2l-8.9-9.2L18.3,15.3z"></path></g><g><polygon points="32,21 32,21 32,21"></polygon></g></symbol><symbol id="facebook" viewBox="0 0 15.2 32"><path d="M15.2,11.1H9.6V7c0-1.2,1.3-1.5,1.9-1.5c0.6,0,3.6,0,3.6,0V0L11,0C5.4,0,4.1,4.1,4.1,6.7v4.4H0v5.6h4.1
        c0,7.3,0,15.2,0,15.2h5.5c0,0,0-8.1,0-15.2h4.7L15.2,11.1z">
        </path></symbol>';

		echo PHP_EOL . '<symbol id="googleplus" viewBox="0 0 32 32"><path d="M18.8,1c1.1-0.6,1.6-1,1.6-1H9.9C7.8,0,2,2.4,2,7.9c0,5.5,6,6.7,8.2,6.6C9,16,10,17.4,10.7,18.1
        c0.7,0.7,0.5,0.9-0.3,0.9C9.7,19,0,19.1,0,26s12.8,7.4,17.1,3.7s3.3-8.9,0-11.2c-3.3-2.3-4.5-3.4-2.4-5.3
        c2.1-1.8,3.7-3.3,3.7-6.8s-2.8-5.2-2.8-5.2S17.7,1.6,18.8,1z M17.1,25.7c0,3-2.5,4.4-6.8,4.4c-4.3,0-6.6-2.1-6.6-5.4
        c0-3.2,3.1-4.8,9-4.8C14.3,21.2,17.1,22.7,17.1,25.7z M10.9,13.2c-5.2,0-7.5-12.1-1.4-12.1C14.2,0.9,17.8,13.2,10.9,13.2z
         M28.1,4V0.1h-2V4h-4v2h4V10h2V6.1H32V4H28.1z"></path></symbol>';

		echo PHP_EOL . '<symbol id="linkedin" viewBox="0 0 31.9 32"><path d="M24,8c-5.1,0.1-7.7,3.8-8,4V8h-6v24h6V18c0-0.5,1.3-4.6,6-4c2.5,0.2,3.9,3.5,4,4v14l6,0V15.4
        C31.7,13,30.5,8.1,24,8z M0,32h6V8H0V32z M3,0C1.3,0,0,1.3,0,3s1.3,3,3,3c1.7,0,3-1.3,3-3S4.7,0,3,0z"></path></symbol>';

		echo PHP_EOL . '<symbol id="pinterest" viewBox="0 0 24.9 32"><path d="M13.2,0C4.4,0,0,6.3,0,11.5c0,3.2,1.2,6,3.8,7c0.4,0.2,0.8,0,0.9-0.5c0.1-0.3,0.3-1.1,0.4-1.5
        c0.1-0.5,0.1-0.6-0.3-1c-0.7-0.9-1.2-2-1.2-3.6c0-4.6,3.5-8.8,9.1-8.8c5,0,7.7,3,7.7,7c0,5.3-2.4,9.8-5.9,9.8
        c-1.9,0-3.4-1.6-2.9-3.5c0.6-2.3,1.6-4.8,1.6-6.5c0-1.5-0.8-2.8-2.5-2.8c-2,0-3.6,2-3.6,4.8c0,1.7,0.6,2.9,0.6,2.9s-2,8.5-2.4,10
        c-0.7,3-0.1,6.6-0.1,7c0,0.2,0.3,0.3,0.4,0.1c0.2-0.2,2.5-3.1,3.3-6c0.2-0.8,1.3-5.1,1.3-5.1c0.6,1.2,2.5,2.3,4.5,2.3
        c5.9,0,10-5.4,10-12.6C24.9,5.1,20.3,0,13.2,0z"></path></symbol>';

		echo PHP_EOL . '<symbol id="reddit" viewBox="0 0 32 26.7"><path d="M22.9,14.5C23,14.7,23,15,23,15.2c0,0.4-0.2,0.9-0.4,1.2c-0.3,0.3-0.6,0.6-1,0.7h0c0,0,0,0,0,0c0,0,0,0,0,0
        c-0.2,0.1-0.4,0.1-0.6,0.1c-0.5,0-0.9-0.2-1.3-0.5c-0.4-0.3-0.6-0.7-0.7-1.2c0,0,0,0,0,0c0,0,0,0,0,0h0c0-0.1,0-0.2,0-0.4
        c0-0.4,0.1-0.8,0.4-1.2c0.2-0.3,0.6-0.6,1-0.7c0,0,0,0,0,0c0,0,0,0,0,0c0.2-0.1,0.5-0.1,0.7-0.1c0.4,0,0.8,0.1,1.2,0.4
        C22.5,13.8,22.7,14.1,22.9,14.5C22.9,14.5,22.9,14.5,22.9,14.5C22.9,14.5,22.9,14.5,22.9,14.5L22.9,14.5z M21.6,19.7
        c-0.2-0.1-0.4-0.2-0.6-0.2c-0.2,0-0.3,0-0.5,0.1c-1.4,0.8-3.1,1.3-4.7,1.3c-1.2,0-2.5-0.3-3.6-0.8l0,0l0,0
        c-0.2-0.1-0.4-0.2-0.6-0.4c-0.1-0.1-0.2-0.1-0.3-0.2c-0.1-0.1-0.3-0.1-0.4-0.1c-0.1,0-0.2,0-0.4,0.1c0,0,0,0,0,0
        c-0.2,0.1-0.3,0.2-0.4,0.4c-0.1,0.2-0.2,0.4-0.2,0.6c0,0.2,0,0.3,0.1,0.5c0.1,0.1,0.2,0.3,0.4,0.4c1.6,1.1,3.5,1.6,5.4,1.6
        c1.7,0,3.4-0.4,4.9-1.1l0,0l0,0c0.2-0.1,0.5-0.2,0.7-0.4c0.1-0.1,0.2-0.2,0.4-0.3c0.1-0.1,0.2-0.3,0.2-0.4c0-0.1,0-0.2,0-0.2
        c0-0.1,0-0.3-0.1-0.4C21.9,19.9,21.8,19.8,21.6,19.7L21.6,19.7z M10.4,17.1C10.4,17.1,10.4,17.1,10.4,17.1
        c0.2,0.1,0.4,0.1,0.6,0.1c0.5,0,1-0.2,1.4-0.6c0.4-0.3,0.6-0.8,0.6-1.4c0,0,0,0,0,0c0,0,0-0.1,0-0.1c0-0.6-0.3-1-0.6-1.4
        c-0.4-0.3-0.9-0.6-1.4-0.6c-0.1,0-0.3,0-0.4,0c0,0,0,0,0,0h0c-0.7,0.1-1.3,0.7-1.5,1.4c0,0,0,0,0,0C9,14.8,9,15,9,15.2
        c0,0.4,0.1,0.9,0.4,1.2C9.6,16.7,10,17,10.4,17.1C10.4,17.1,10.4,17.1,10.4,17.1L10.4,17.1z M32,12.1L32,12.1c0,0.1,0,0.1,0,0.2
        c0,0.8-0.2,1.5-0.7,2.2c-0.4,0.6-0.9,1.1-1.5,1.4c0,0.3,0.1,0.6,0.1,0.9c0,1.7-0.6,3.3-1.6,4.6v0h0c-1.9,2.5-4.7,3.9-7.6,4.7l0,0
        c-1.5,0.4-3.1,0.6-4.7,0.6c-2.4,0-4.7-0.4-6.9-1.3v0h0c-2.3-0.9-4.5-2.4-5.8-4.6c-0.7-1.2-1.1-2.5-1.1-3.9c0-0.3,0-0.6,0.1-0.9
        c-0.6-0.3-1.1-0.8-1.5-1.4C0.3,13.9,0,13.2,0,12.4v0c0-1.1,0.5-2.1,1.2-2.8c0.7-0.7,1.7-1.2,2.8-1.2h0c0.1,0,0.2,0,0.3,0
        c0.5,0,1.1,0.1,1.6,0.3l0,0h0C6.3,8.8,6.8,9,7.1,9.3c0.1-0.1,0.3-0.1,0.4-0.2c2.3-1.4,5-1.9,7.6-2c0-1.3,0.2-2.7,0.8-3.8
        c0.5-1,1.4-1.8,2.5-2l0,0h0c0.4-0.1,0.8-0.1,1.2-0.1c1.1,0,2.2,0.3,3.2,0.7c0.5-0.7,1.1-1.2,1.9-1.5l0,0l0,0
        C25.3,0.1,25.8,0,26.2,0c0.5,0,1,0.1,1.5,0.3v0c0,0,0,0,0,0c0,0,0,0,0,0C28.4,0.6,29,1,29.4,1.6C29.8,2.2,30,3,30,3.7
        c0,0.1,0,0.3,0,0.4l0,0c0,0,0,0,0,0c-0.1,1-0.6,1.8-1.2,2.4c-0.7,0.6-1.6,1-2.5,1c-0.1,0-0.3,0-0.4,0c-0.9-0.1-1.8-0.5-2.4-1.2
        c-0.6-0.7-1-1.5-1-2.5c0,0,0-0.1,0-0.1C21.6,3.3,20.7,3,19.8,3c-0.1,0-0.3,0-0.4,0h0c-0.7,0.1-1.3,0.5-1.6,1.1v0
        c-0.5,0.9-0.6,1.9-0.6,3c2.6,0.2,5.2,0.8,7.4,2.1h0l0,0c0,0,0.1,0.1,0.2,0.1C25,9.2,25.2,9,25.4,8.9c0.7-0.5,1.5-0.7,2.3-0.7
        c0.4,0,0.7,0,1.1,0.1h0l0,0c0,0,0,0,0,0c0.8,0.2,1.6,0.7,2.2,1.3C31.5,10.4,31.9,11.2,32,12.1L32,12.1L32,12.1z M24.4,3.6
        c0,0,0,0.1,0,0.1v0c0,0.4,0.2,0.9,0.6,1.2c0.3,0.3,0.8,0.5,1.2,0.5h0c0,0,0.1,0,0.1,0c0.4,0,0.9-0.2,1.2-0.5
        C27.8,4.6,28,4.2,28,3.8v0c0,0,0-0.1,0-0.1c0-0.5-0.2-0.9-0.6-1.2c-0.3-0.3-0.8-0.5-1.2-0.5c-0.1,0-0.3,0-0.4,0.1h0l0,0
        c-0.4,0.1-0.7,0.3-1,0.6C24.6,2.9,24.4,3.2,24.4,3.6L24.4,3.6z M5.4,10.5c-0.3-0.2-0.7-0.3-1.1-0.3c-0.1,0-0.1,0-0.2,0h0l0,0
        c-0.5,0-1,0.2-1.4,0.6c-0.4,0.4-0.6,0.8-0.7,1.4v0l0,0c0,0,0,0.1,0,0.1c0,0.3,0.1,0.6,0.3,0.9c0.1,0.2,0.3,0.4,0.5,0.6
        C3.4,12.6,4.3,11.5,5.4,10.5L5.4,10.5z M27.8,16.9c0-1.2-0.4-2.3-1.1-3.2c-1.3-1.9-3.4-3.1-5.6-3.8l0,0c-0.4-0.1-0.8-0.2-1.3-0.3
        c-1.3-0.3-2.6-0.4-3.9-0.4c-1.7,0-3.5,0.3-5.2,0.8c-2.2,0.7-4.3,1.9-5.6,3.8v0c-0.7,0.9-1.1,2.1-1.1,3.3c0,0.4,0.1,0.9,0.2,1.3
        l0,0c0.2,0.9,0.7,1.8,1.3,2.5c0.6,0.7,1.4,1.3,2.2,1.8c0.2,0.1,0.4,0.2,0.5,0.3c2.3,1.3,5,1.9,7.6,1.9c0.4,0,0.9,0,1.3,0
        c2.7-0.2,5.3-1,7.5-2.6v0c0.7-0.5,1.3-1.1,1.8-1.8c0.5-0.7,0.9-1.5,1-2.3v0C27.8,17.5,27.8,17.2,27.8,16.9L27.8,16.9z M29.9,12.3
        c0-0.3-0.1-0.6-0.2-0.8l0,0l0,0c-0.2-0.4-0.5-0.7-0.8-0.9c-0.4-0.2-0.8-0.3-1.2-0.3c-0.4,0-0.7,0.1-1.1,0.3c1.1,0.9,2,2,2.6,3.3
        c0.2-0.2,0.4-0.4,0.5-0.6C29.8,13,29.9,12.6,29.9,12.3L29.9,12.3z M29.9,12.3"></path></symbol>';

		echo PHP_EOL . '<symbol id="twitter" viewBox="0 0 32.5 28.4"><path d="M32.5,3.4c-0.5,0.3-2.2,1-3.7,1.1c1-0.6,2.4-2.4,2.8-3.9c-0.9,0.6-3.1,1.6-4.2,1.6c0,0,0,0,0,0
        C26.1,0.9,24.4,0,22.5,0c-3.7,0-6.7,3.2-6.7,7.2c0,0.6,0.1,1.1,0.2,1.6h0C11,8.7,5.1,6,1.8,1.3c-2,3.8-0.3,8,2,9.5
        c-0.8,0.1-2.2-0.1-2.9-0.8c0,2.5,1.1,5.8,5.2,7c-0.8,0.5-2.2,0.3-2.8,0.2c0.2,2.1,3,4.9,6,4.9c-1.1,1.3-4.7,3.8-9.3,3
        c3.1,2,6.7,3.2,10.5,3.2c10.8,0,19.2-9.4,18.7-21.1c0,0,0,0,0,0c0,0,0-0.1,0-0.1c0,0,0-0.1,0-0.1C30.2,6.4,31.5,5.1,32.5,3.4z"></path></symbol>';

		echo '</svg>';

	}


	/**
	 * Add og: meta tags to the header. Used for Facebook to generate the nice share window details
	 */
	public function og_tags() {


		// Create/check default values
		$info['postID']              = absint( get_the_ID() );
		$info['title']               = esc_html( get_the_title() );
		$info['imageURL']            = get_post_thumbnail_id( $info['postID'] );
		$info['description']         = esc_html( $this->get_excerpt_by_id( $info['postID'] ) );
		$info['user_twitter_handle'] = esc_attr( parent::get_option_value( 'misc-settings-twitter-handle' ) );
		$info['header_output']       = '';


		// We only modify the Open Graph tags on single blog post pages
		if ( is_singular() ) {

			if ( ( isset( $info['title'] ) && $info['title'] ) || ( isset( $info['description'] ) && $info['description'] ) || ( isset( $info['imageURL'] ) && $info['imageURL'] ) ) {

				/*****************************************************************
				 *                                                                *
				 *     YOAST SEO: It rocks, so let's coordinate with it             *
				 *                                                                *
				 ******************************************************************/

				// Check if Yoast Exists so we can coordinate output with their plugin accordingly
				if ( ! defined( 'WPSEO_VERSION' ) ) {


					// Add all our Open Graph Tags to the Return Header Output
					$info['header_output'] .= PHP_EOL . '<!-- Meta OG tags by Kiwi Social Sharing Plugin -->';
					$info['header_output'] .= PHP_EOL . '<meta property="og:type" content="article" /> ';


					/*****************************************************************
					 *                                                                *
					 *     OPEN GRAPH TITLE                                             *
					 *                                                                *
					 ******************************************************************/

					// Open Graph Title: Create an open graph title meta tag
					if ( $info['title'] ) {

						// If nothing else is defined, let's use the post title
						$info['header_output'] .= PHP_EOL . '<meta property="og:title" content="' . $this->convert_smart_quotes( htmlspecialchars_decode( get_the_title() ) ) . '" />';

					}

					/*****************************************************************
					 *                                                                *
					 *     OPEN GRAPH DESCRIPTION                                     *
					 *                                                                *
					 ******************************************************************/

					if ( $info['description'] ) {

						// If nothing else is defined, let's use the post excerpt
						$info['header_output'] .= PHP_EOL . '<meta property="og:description" content="' . $this->convert_smart_quotes( htmlspecialchars_decode( $this->get_excerpt_by_id( $info['postID'] ) ) ) . '" />';

					}

					/*****************************************************************
					 *                                                                *
					 *     OPEN GRAPH IMAGE                                             *
					 *                                                                *
					 ******************************************************************/

					if ( has_post_thumbnail( $info['postID'] ) ) {


						// If nothing else is defined, let's use the post Thumbnail as long as we have the URL cached
						$og_image = wp_get_attachment_image_src( get_post_thumbnail_id( $info['postID'] ), 'full' );

						if ( $og_image ) {
							$info['header_output'] .= PHP_EOL . '<meta property="og:image" content="' . esc_url( $og_image[0] ) . '" />';
						}

					} else {
						$og_image = KIWI__PLUGINS_URL . 'admin/images/placeholder-image.png';
						$info['header_output'] .= PHP_EOL . '<meta property="og:image" content="' . esc_url( $og_image ) . '" >';
					}

					/*****************************************************************
					 *                                                                *
					 *     OPEN GRAPH URL                                             *
					 *     OPEN GRAPH Site Name                                       *
					 *     OPEN GRAPH Article Published Time                          *
					 *     OPEN GRAPH Article Modified Time                           *
					 *     OPEN GRAPH Article Updated Time                            *
					 *                                                                *
					 ******************************************************************/

					$info['header_output'] .= PHP_EOL . '<meta property="og:url" content="' . get_permalink() . '" />';
					$info['header_output'] .= PHP_EOL . '<meta property="og:site_name" content="' . get_bloginfo( 'name' ) . '" />';
					$info['header_output'] .= PHP_EOL . '<meta property="article:published_time" content="' . get_post_time( 'c' ) . '" />';
					$info['header_output'] .= PHP_EOL . '<meta property="article:modified_time" content="' . get_post_modified_time( 'c' ) . '" />';
					$info['header_output'] .= PHP_EOL . '<meta property="og:updated_time" content="' . get_post_modified_time( 'c' ) . '" />';


					// append the closing comment :)
					$info['header_output'] .= PHP_EOL . '<!--/end meta tags by Kiwi Social Sharing Plugin -->';

					// Return the variable containing our information for the meta tags
					echo $info['header_output'];

				}
			}
		}
	}
} // class ends

$kiwi_render_share_bar = new Kiwi_Render_Share_Bar();