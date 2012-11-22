<?php


class WP6toolsExample extends WP_Widget {

	/**
	 * Constructeur du Widget
	 *
	 * @return void
         * @since 6Tools 0.1
	 */
	function WP6toolsExample() {
            
		$this->WP_Widget(
			'wp6tools_base_widget',
			__('> Widget de Base', WP6tools::$textdomain),
			array(
				'classname' => 'widget-wp6tools-base-widget',
				'description' => __( ' WP6tools - Widget de base pour développement', WP6tools::$textdomain )
			)
		);
	}
        

	/**
	 * Fonction par défaut des paramètres du widget
	 *
	 * @return array
	 */
	function getFields() {
		return array(
			'title'     =>      'Titre'
		);
	}
        

	/**
	 * Méthode appelée par l'API Widget // Corps du widget côté front
	 *
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	function widget( $args, $instance ) {

            extract( $args );

		foreach ( (array) $this->getFields() as $field => $field_value ) {
			${$field} = trim( $instance[$field] );
		}

                echo $before_widget;
		
                ?>

                
                <div class="widget-de-base">
                    <p>Widget : <?php echo $title; ?></p>
                </div>


                <?php

                echo $after_widget;
	}
        
        
	/**
	 * Méthode appelée par l'API Widget // Mise à jour des champs
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 * @return array
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		foreach ( (array) $this->getFields() as $field => $field_value ) {
			$instance[$field] = strip_tags($new_instance[$field]);
		}

		return $instance;
	}
        

	/**
	 * Méthode appelée par l'API Widget // Paramètres du widget dans l'admin
	 *
	 * @param array $instance
	 * @return void
	 */
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->getFields() );
		foreach ( (array) $this->getFields() as $field => $field_value ) {
			${$field} = esc_attr( $instance[$field] );
		}

		?>

		<p>
                    <label for="<?php echo $this->get_field_id('title'); ?>">
                            <?php _e('Title:', WP6tools::$textdomain); ?>
                            <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
                    </label>
		</p>
               
		
		<?php
	}
}
?>
