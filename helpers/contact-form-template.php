<p><?php esc_html_e( 'You have a new contact from enquiry!', 'vc_ase' ); ?></p>

<h3><?php echo esc_html( $subject ); ?></h3>

<p>
	<strong><?php esc_html_e( 'Name', 'vc_ase' ); ?>: </strong><?php echo esc_html( $name ); ?><br>
	<strong><?php esc_html_e( 'Email', 'vc_ase' ); ?>: </strong><a href="mailto:<?php echo sanitize_email( $email ); ?>"><?php echo sanitize_email( $email ); ?></a>
</p>

<p>
	<?php echo esc_html( $message ); ?>
</p>
