<?php

/**
 * WP_Mail
 *
 * A simple class for creating and
 * sending Emails using WordPress
 *
 * @author AnthonyBudd <anthonybudd94@gmail.com>
 * @link   https://github.com/anthonybudd/WP_Mail https://medium.com/@AnthonyBudd/wp-mail-send-templated-emails-with-wordpress-314a71f83db2
 * Note: file has been converted to comply WordPress Coding Standards (WPCS)
 */
class WP_Mail {

	private $to           = array();
	private $cc           = array();
	private $bcc          = array();
	private $headers      = array();
	private $attachments  = array();
	private $send_as_html = true;
	private $subject      = '';
	private $from         = '';

	private $header_template  = false;
	private $header_variables = array();
	private $template         = false;
	private $variables        = array();
	private $after_template   = false;
	private $footer_variables = array();


	public static function init() {
		return new self;
	}


	/**
	 * Set recipients
	 * @param  Array|String $to
	 * @return Object $this
	 */
	public function to( $to ) {
		if ( is_array( $to ) ) {
			$this->to = $to;
		} else {
			$this->to = array( $to );
		}
		return $this;
	}


	/**
	 * Get recipients
	 * @return Array $to
	 */
	public function get_to() {
		return $this->to;
	}


	/**
	 * Set Cc recipients
	 * @param  String|Array $cc
	 * @return Object $this
	 */
	public function cc( $cc ) {
		if ( is_array( $cc ) ) {
			$this->cc = $cc;
		} else {
			$this->cc = array( $cc );
		}
		return $this;
	}


	/**
	 * Get Cc recipients
	 * @return Array $cc
	 */
	public function get_cc() {
		return $this->cc;
	}


	/**
	 * Set Email Bcc recipients
	 * @param  String|Array $bcc
	 * @return Object $this
	 */
	public function bcc( $bcc ) {
		if ( is_array( $bcc ) ) {
			$this->bcc = $bcc;
		} else {
			$this->bcc = array( $bcc );
		}

		return $this;
	}


	/**
	 * Set email Bcc recipients
	 * @return Array $bcc
	 */
	public function get_bcc() {
		return $this->bcc;
	}


	/**
	 * Set email Subject
	 * @param  Srting $subject
	 * @return Object $this
	 */
	public function subject( $subject ) {
		$this->subject = $subject;
		return $this;
	}


	/**
	 * Retruns email subject
	 * @return Array
	 */
	public function get_subject() {
		return $this->subject;
	}


	/**
	 * Set From header
	 * @param  String
	 * @return Object $this
	 */
	public function from( $from ) {
		$this->from = $from;
		return $this;
	}

	/**
	 * Set the email's headers
	 * @param  String|Array  $headers [description]
	 * @return Object $this
	 */
	public function headers( $headers ) {
		if ( is_array( $headers ) ) {
			$this->headers = $headers;
		} else {
			$this->headers = array( $headers );
		}

		return $this;
	}


	/**
	 * Retruns headers
	 * @return Array
	 */
	public function get_headers() {
		return $this->headers;
	}


	/**
	 * Returns email content type
	 * @return String
	 */
	public function html_filter() {
		return 'text/html';
	}


	/**
	 * Set email content type
	 * @param  Bool $html
	 * @return Object $this
	 */
	public function send_as_html( $html ) {
		$this->send_as_html = $html;
		return $this;
	}


	/**
	 * Attach a file or array of files.
	 * Filepaths must be absolute.
	 * @param  String|Array $path
	 * @throws Exception
	 * @return Object $this
	 */
	public function attach( $path ) {
		if ( is_array( $path ) ) {
			$this->attachments = array();
			foreach ( $path as $path_ ) {
				if ( ! file_exists( $path_ ) ) {
					throw new Exception( 'Attachment not found at' . $path );
				} else {
					$this->attachments[] = $path_;
				}
			}
		} else {
			if ( ! file_exists( $path ) ) {
				throw new Exception( 'Attachment not found at' . $path );
			}
			$this->attachments = array( $path );
		}

		return $this;
	}


	/**
	 * Set the before-template file
	 * @param  String $template  Path to HTML template
	 * @param  Array  $variables
	 * @throws Exception
	 * @return Object $this
	 */
	public function template_header( $template, $variables = null ) {
		if ( ! file_exists( $template ) ) {
			throw new Exception( 'Template file not found' );
		}

		if ( is_array( $variables ) ) {
			$this->header_variables = $variables;
		}

		$this->header_template = $template;
		return $this;
	}


	/**
	 * Set the template file
	 * @param  String $template  Path to HTML template
	 * @param  Array  $variables
	 * @throws Exception
	 * @return Object $this
	 */
	public function template( $template, $variables = null ) {
		if ( ! file_exists( $template ) ) {
			throw new Exception( 'File not found' );
		}

		if ( is_array( $variables ) ) {
			$this->variables = $variables;
		}

		$this->template = $template;
		return $this;
	}


	/**
	 * Set the after-template file
	 * @param  String $template  Path to HTML template
	 * @param  Array  $variables
	 * @throws Exception
	 * @return Object $this
	 */
	public function template_footer( $template, $variables = null ) {
		if ( ! file_exists( $template ) ) {
			throw new Exception( 'Template file not found' );
		}

		if ( is_array( $variables ) ) {
			$this->footer_variables = $variables;
		}

		$this->after_template = $template;
		return $this;
	}


	/**
	 * Renders the template
	 * @return String
	 */
	public function render() {
		return $this->render_part( 'before' ) . $this->render_part( 'main' ) . $this->render_part( 'after' );
	}

	/**
	 * Render a specific part of the email
	 * @author Anthony Budd
	 * @param  String $part before, after, main
	 * @return String
	 */
	public function render_part( $part = 'main' ) {
		switch ( $part ) {
			case 'before':
				$template_file = $this->header_template;
				$variables     = $this->header_variables;
				break;

			case 'after':
				$template_file = $this->after_template;
				$variables     = $this->footer_variables;
				break;

			case 'main':
			default:
				$template_file = $this->template;
				$variables     = $this->variables;
				break;
		}

		if ( false === $template_file ) {
			return '';
		}

		$extension = strtolower( pathinfo( $template_file, PATHINFO_EXTENSION ) );
		if ( 'php' === $extension ) {

			ob_start();
			ob_clean();

			foreach ( $variables as $key => $value ) {
				$$key = $value;
			}

			include $template_file;

			$html = ob_get_clean();

			return $html;

		} elseif ( 'html' === $extension ) {

			$template = file_get_contents( $template_file );

			if ( ! is_array( $variables ) || empty( $variables ) ) {
				return $template;
			}

			return $this->parse_as_mustache( $template, $variables );

		} else {
			throw new Exception( "Unknown extension {$extension} in path '{$template_file}'" );
		}
	}

	public function build_subject() {
		return $this->parse_as_mustache(
			$this->subject,
			array_merge(
				$this->header_variables,
				$this->variables,
				$this->footer_variables
			)
		);
	}

	public function parse_as_mustache( $string, $variables = array() ) {

		preg_match_all( '/\{\{\s*.+?\s*\}\}/', $string, $matches );

		foreach ( $matches[0] as $match ) {
			$var = str_replace( '{', '', str_replace( '}', '', preg_replace( '/\s+/', '', $match ) ) );

			if ( isset( $variables[ $var ] ) && ! is_array( $variables[ $var ] ) ) {
				$string = str_replace( $match, $variables[ $var ], $string );
			}
		}

		return $string;
	}


	/**
	 * Builds Email Headers
	 * @return String email headers
	 */
	public function build_headers() {
		$headers = '';

		$headers .= implode( "\r\n", $this->headers ) . "\r\n";

		foreach ( $this->bcc as $bcc ) {
			$headers .= sprintf( "Bcc: %s \r\n", $bcc );
		}

		foreach ( $this->cc as $cc ) {
			$headers .= sprintf( "Cc: %s \r\n", $cc );
		}

		if ( ! empty( $this->from ) ) {
			$headers .= sprintf( "From: %s \r\n", $this->from );
		}

		return $headers;
	}


	/**
	 * Sends a rendered email using
	 * WordPress's wp_mail() function
	 * @return Bool
	 */
	public function send() {
		if ( count( $this->to ) === 0 ) {
			throw new Exception( __( 'You must set at least 1 recipient', 'vc_ase' ) );
		}

		if ( empty( $this->template ) ) {
			throw new Exception( __( 'You must set a template', 'vc_ase' ) );
		}

		if ( $this->send_as_html ) {
			add_filter( 'wp_mail_content_type', array( $this, 'html_filter' ) );
		}

		return wp_mail( $this->to, $this->build_subject(), $this->render(), $this->build_headers(), $this->attachments );
	}
}
