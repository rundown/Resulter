<?php
function resulter_register_settings() {
	add_option( 'resulter_db_hostname', 'localhost');
	add_option( 'resulter_db_username', '');
	add_option( 'resulter_db_password', '');
	add_option( 'resulter_db_database', '');
	register_setting( 'default', 'resulter_db_hostname' ); 
	register_setting( 'default', 'resulter_db_username' ); 
	register_setting( 'default', 'resulter_db_password' ); 
	register_setting( 'default', 'resulter_db_database' ); 
} 
add_action( 'admin_init', 'resulter_register_settings' );
 
function resulter_register_options_page() {
	add_options_page('Resulter Settings', 'Resulter by Gaurav', 'administrator', 'resulter-options', 'resulter_options_page');
}
add_action('admin_menu', 'resulter_register_options_page');
 
function resulter_options_page() {
	?>
<div class="wrap">
	<?php screen_icon(); ?>
	<h2>Resulter Global Options</h2>
	<form method="post" action="options.php"> 
		<?php settings_fields( 'default' ); ?>
		<h3>Database Settings</h3>
			<p>Settings related to the database.</p>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="resulter_db_hostname">Hostname of the database</label></th>
					<td><input type="text" id="resulter_db_hostname" name="resulter_db_hostname" value="<?php echo get_option('resulter_db_hostname'); ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="resulter_db_username">Database username</label></th>
					<td><input type="text" id="resulter_db_username" name="resulter_db_username" value="<?php echo get_option('resulter_db_username'); ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="resulter_db_password">Database password</label></th>
					<td><input type="text" id="resulter_db_password" name="resulter_db_password" value="<?php echo get_option('resulter_db_password'); ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="resulter_db_database">Database name</label></th>
					<td><input type="text" id="resulter_db_database" name="resulter_db_database" value="<?php echo get_option('resulter_db_database'); ?>" /></td>
				</tr>
			</table>
		<?php submit_button(); ?>
	</form>
</div>
<?php
}
?>