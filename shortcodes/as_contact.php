<?php
function vc_ase_as_contact_func( $atts, $content = null ) {

	extract(
		shortcode_atts(
			array(

				'title'               => '',
				'subtitle'            => '',
				'sub_position'        => 'bellow',
				'title_style'         => 'center',
				'title_custom_css'    => '',
				'subtitle_custom_css' => '',
				'title_color'         => '',
				'subtitle_color'      => '',
				'title_size'          => '',
				'heading_css'         => '',
				'enter_anim'          => 'none',
				'contact_email'       => get_option( 'admin_email' ),
				'attach_id'           => '',
				'img_format'          => 'thumbnail',
				'show_desc'           => '',
				'css'                 => '',
				'css_classes'         => '',
				'block_id'            => apply_filters( 'vc_ase_randomString', 10 ),
			), $atts
		)
	);

	$text         = wpb_js_remove_wpautop( $content, true );
	$vc_css_class = vc_shortcode_custom_css_class( $css, ' ' );
	$additional   = ( $attach_id || $show_desc ) ? true : false; // if additional text or image

	// HTML STARTS HERE.
	ob_start();

	echo $css_classes ? '<div class="' . esc_attr( $css_classes ) . '">' : ''; ?>

	<div id="contact-block-<?php echo esc_attr( $block_id ); ?>" class="vc-ase-element vcase-contact-form<?php echo ( $additional ? ' row' : '' ); ?> <?php echo esc_attr( $vc_css_class ); ?>">

		<div class="anim-wrap">

			<?php do_action( 'vc_ase_block_heading', $title, $subtitle, $title_style, $sub_position, $title_custom_css, $subtitle_custom_css, $title_color, $subtitle_color, $title_size, $heading_css ); ?>

			<?php echo $additional ? '<div class="small-12 medium-6 column form-half">' : ''; ?>

			<div class="contactform-wrapper contactform-<?php echo esc_attr( $block_id ); ?>">

				<div class="mail-status"></div>

				<div class="username">
					<label><?php echo apply_filters( 'vc_ase_contact_name', esc_html__( 'Name', 'vc_ase' ) ); ?></label>
					<span class="info"></span><br/>
					<input type="text" name="userName" id="userName" class="vc_ase_contact_input">
				</div>

				<div class="useremail">
					<label><?php echo apply_filters( 'vc_ase_contact_email', esc_html__( 'Email', 'vc_ase' ) ); ?></label>
					<span class="info"></span><br/>
					<input type="text" name="userEmail" id="userEmail" class="vc_ase_contact_input">
				</div>

				<div class="subject">
					<label><?php echo apply_filters( 'vc_ase_contact_subject', esc_html__( 'Subject', 'vc_ase' ) ); ?></label> 
					<span class="info"></span><br/>
					<input type="text" name="subject" id="subject" class="vc_ase_contact_input">
				</div>

				<div class="message">
					<label><?php echo apply_filters( 'vc_ase_contact_message', esc_html__( 'Message', 'vc_ase' ) ); ?></label> 
					<span class="info"></span><br/>
					<textarea name="message" id="message" class="vc_ase_contact_input" cols="60" rows="6"></textarea>
				</div>

				<div>
					<button name="submit" class="button send-button"><?php echo apply_filters( 'vc_ase_contact_send', esc_html__( 'Send', 'vc_ase' ) ); ?></button>
				</div>

			</div>

			<?php echo $additional ? '</div>' : null; // end .form-half ?>

			<?php echo $additional ? '<div class="small-12 medium-6 column contact-additional">' : null; ?>

				<?php
				if ( $attach_id ) {

					$attr = array(
						'class' => 'contact-form-location-image',
						'title' => $title ? esc_attr( $title ) : '',
						'alt'   => $title ? esc_attr( $title ) : '',
					);

					echo '<div class="entry-image">' . wp_get_attachment_image( $attach_id, $img_format, false, $attr ) . '</div>';

				};
				?>

				<?php if ( $show_desc ) { ?>
				<div class="location-description">

					<?php echo wp_kses_post( $text ); ?>

				</div>
					<?php
};

				echo $additional ? '</div>' : null; // end .contact-additional
?>

		</div><!-- .anim-wrap -->

	</div> <!-- .contact-form -->

<script>
(function($) {
	"use strict";
	$(document).ready( function() {

		var thisBlock = $('#contact-block-<?php echo esc_js( $block_id ); ?>');

		if ( !window.vcase_isMobile && !window.isIE9 ) {

			var anim_wrap = thisBlock.find('.anim-wrap');

			thisBlock.waypoint(

				function(direction) {

					if( 'up' === direction ) {	

						anim_wrap.removeClass('animated <?php echo esc_js( $enter_anim ); ?>').addClass('to-anim');

					} else if ( 'down' === direction ) {

						anim_wrap.addClass( 'animated <?php echo esc_js( $enter_anim ); ?>').removeClass( 'to-anim' );

					}
				}, 
				{ offset: '98%' }

			);

		} else {

			anim_wrap.each( function() {

				$(this).removeClass('to-anim');

			});

		}

	} );// end doc ready

})( jQuery );
</script>

	<?php echo $css_classes ? '</div>' : null; ?>

	<?php
	$required = __( 'Required field', 'vc_ase' );
	$invalid  = __( 'Invalid email', 'vc_ase' );
	?>

<script type="text/javascript">
(function($) {
	"use strict";

	$( document ).ready( function() {

		var ajaxurl = vc_ase_jsvars.vc_ase_ajax_url;
		// find form with unique class (randomized) and input fields
		var contactForm = $('.contactform-<?php echo esc_attr( $block_id ); ?>'),
			username    = contactForm.find( '.username' ).find( 'input' ),
			useremail   = contactForm.find( '.useremail' ).find( 'input' ),
			subject     = contactForm.find( '.subject' ).find( 'input' ),
			message     = contactForm.find( '.message' ).find( 'textarea' ),
			allfields   = contactForm.find( '> div:not(.mail-status)' );
		// set element for message info (required,invalid)
		var usernameInfo  = contactForm.find( '.username' ).find('.info' ),
			useremailInfo = contactForm.find( '.useremail' ).find('.info' ),
			subjectInfo   = contactForm.find( '.subject' ).find('.info' ),
			messageInfo   = contactForm.find( '.message' ).find('.info' );
		// send button
		var sendButton = contactForm.find('.send-button');
		// sending status element, and return strings
		var mailStatus = contactForm.find('.mail-status'),
			mailSent   = "<?php echo esc_js( __( 'Your e-mail message was sent.', 'vc_ase' ) ); ?>",
			mailError  = "<?php echo esc_js( __( 'Problem in sending e-mail.', 'vc_ase' ) ); ?>";

		// ajax sending message
		function sendContact_<?php echo esc_attr( $block_id ); ?>() {

			var valid = validateContact_<?php echo esc_js( $block_id ); ?>();

			if ( valid ) {

				$.ajax({
					url:  ajaxurl,
					data: {
						action    : "vc_ase_contactform",
						userName  : username.val(),
						userEmail : useremail.val(),
						subject   : subject.val(),
						message   : message.val(),
						recipient : "<?php echo esc_js( $contact_email ); ?>",
						mailsent  : mailSent,
						mailerror : mailError
					},
					type: "POST",
					success: function( response ) {
						allfields.css("opacity",0.5);
						mailStatus.html( response );
						mailStatus.css('display','table-cell');
						console.log(ajaxurl);
					},
					error:function(response) { console.log("Failed");}
				});
			}
		} // end func sendContact
		// basic form validation
		function validateContact_<?php echo esc_js( $block_id ); ?>() {

			var valid    = true,
				required = "( <?php echo esc_js( $required ); ?> )",
				invalid  = "( <?php echo esc_js( $invalid ); ?> )";	

			$(".vc_ase_contact_input").css('background-color','');
			$(".info").html('');

			if ( ! username.val() ) {
				usernameInfo.html( required );
				username.css('background-color','#FFFFDF');
				valid = false;
			}
			if ( ! useremail.val() ) {
				useremailInfo.html( required );
				useremail.css('background-color','#FFFFDF');
				valid = false;
			}
			if ( ! useremail.val().match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/) ) {
				useremailInfo.html( invalid );
				useremail.css('background-color','#FFFFDF');
				valid = false;
			}
			if ( ! subject.val() ) {
				subjectInfo.html( required );
				subject.css('background-color','#FFFFDF');
				valid = false;
			}
			if ( ! message.val() ) {
				messageInfo.html( required );
				message.css('background-color','#FFFFDF');
				valid = false;
			}

			return valid;
		} // end func validateContact

		// trigger sending with button
		sendButton.on( 'click', function() {
			sendContact_<?php echo esc_attr( $block_id ); ?>();
		});

		// close message element, hide overlay wrapper, all fields back to opacity:1 , empty fields
		$(document).on( 'click', '.close-alert', function(e) {
			e.preventDefault();
			$(this).parent().slideToggle( 150, function() {
				$(this).parent().css("display","none");
				$('.vc_ase_contact_input').val("");
				allfields.css("opacity",1);
			});

		});

	}); // end doc ready

})(jQuery);
</script>
	<?php
	$output_string = ob_get_contents();

	ob_end_clean();

	return $output_string;
	####################  HTML ENDS HERE: ###########################
}

add_shortcode( 'as_contact', 'vc_ase_as_contact_func' );
