<?php
/**
 * Admin options template
 */
?>

<div class="wrap">
    <div class="icon32" id="icon-options-general"><br /></div>
    <h2><?php _e('6Tools Options', $namespace); ?></h2>
    
    <h3><?php _e('6Tools All Parameters', $namespace); ?></h3>
    
    <p>Mauris vitae sem nunc. Nam dapibus adipiscing fermentum. Maecenas bibendum, justo sit amet fermentum consectetur, augue turpis pellentesque est, nec euismod ligula quam id ligula. Maecenas nec lorem turpis, ut sollicitudin purus. </p>

    <form action="options.php" method="post" id="<?php echo $namespace; ?>-form">
        
        <?php
            settings_fields( $admin_options_slug );
        ?>
        
        
        <table class="form-table">
	<tr>
		<th><?php _e('Change Option 1', $namespace);?>:</th>
		<td>
                    <input type="text" name="<?php echo $admin_options_slug; ?>[option1]" value="<?php echo $this->get_admin_option('option1');?>" class="regular-text"  /><br/>
                    <label><code><?php _e("Example of code", $namespace); ?></code></label>
                </td>
        </tr>
	<tr>
		<th><?php _e('Change Option 2', $namespace);?>:</th>
		<td>
                    <input type="text" name="<?php echo $admin_options_slug; ?>[option2]" value="<?php echo $this->get_admin_option('option2');?>" class="regular-text" /><br/>
                    <label><code><?php _e("Example of large and long code", $namespace); ?></code></label>
                </td>
        </tr>
	<tr>
		<th><?php _e('Change Option 3', $namespace);?>:</th>
		<td>
                    <input type="text" name="<?php echo $admin_options_slug; ?>[option3]" value="<?php echo $this->get_admin_option('option3');?>" class="regular-text" /><br/>
                    <label><code><?php _e("Example of large and long code", $namespace); ?></code></label>
                </td>
        </tr>
        </table>
        
        <p class="submit">
            <input type="submit" name="Submit" class="button-primary" value="<?php _e( "Save Changes" ) ?>" />
        </p>
    </form>
    
</div>
