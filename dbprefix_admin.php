<?php 
	if($_POST['dbprefix_hidden'] == 'Y') { 
		//Form data sent
		$old_dbprefix = $_POST['dbprefix_old_dbprefix'];
		update_option('dbprefix_old_dbprefix', $old_dbprefix);

		$dbprefix_new = $_POST['dbprefix_new'];
		update_option('dbprefix_new', $dbprefix_new);
		
		
		$tables = dbprefix_getTablesToAlter();
		
		
		if (empty($tables))
		{
			$bprefix_Message .= dbprefix_eInfo('There are no tables to rename!');
		}
		else
		{
			$result = dbprefix_renameTables($tables, $old_dbprefix, $dbprefix_new);
			
			// check for errors
			if (!empty($result))
			{
				$bprefix_Message .= _e('All tables have been successfully updated!','success');
		
				// try to rename the fields
				$bprefix_Message .= dbprefix_renameDbFields($old_dbprefix, $dbprefix_new);
				
				$dbprefix_wpConfigFile=ABSPATH.'wp-config.php';
		
				if (dbprefix_updateWpConfigTablePrefix($dbprefix_wpConfigFile, $old_dbprefix, $dbprefix_new))
				{
					$bprefix_Message .= _e('The wp-config file has been successfully updated!','success');
				}
				else {
					$bprefix_Message .= _e('The wp-config file could not be updated! You have to manually update the table_prefix variable to the one you have specified: '.$dbprefix_new);
				}
			}// End if tables successfully renamed
			else {
				$bprefix_Message .= _e('An error has occurred and the tables could not be updated!');
			}
		}// End if there are tables to rename
		
		?>
		<div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
		<?php
	} else {
		//Normal page display
		$dbhost = get_option('dbprefix_dbhost');
		$dbname = get_option('dbprefix_dbname');
		$dbuser = get_option('dbprefix_dbuser');
		$dbpwd = get_option('dbprefix_dbpwd');
		$dbprefix_exist = get_option('dbprefix_prefix_exist');
		$dbprefix_new = get_option('dbprefix_new');
	}
	
	
?>

<div class="wrap">
<?php    echo "<h2>" . __( 'Database Prefix change Display Options', 'oscimp_trdom' ) . "</h2>"; ?>

<form name="dbprefix_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
<input type="hidden" name="dbprefix_hidden" value="Y">

<?php    echo "<h4>" . __( 'Database Prefix Settings', 'dbprefix_trdom' ) . "</h4>"; 
global $wpdb;
?>
<p><?php _e("Existing Prefix: " ); ?><input type="text" name="dbprefix_old_dbprefix" value="<?php echo $wpdb->prefix; ?>" size="20"><?php _e(" ex:wp_" ); ?></p>
<p><?php _e("New Prefix: " ); ?><input type="text" name="dbprefix_new" value="" size="20"><?php _e(" ex: uniquekey_" ); ?></p>

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options', 'dbprefix_trdom' ) ?>" />
</p>
</form>
</div>
