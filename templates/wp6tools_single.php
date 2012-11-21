<?php
/**
* Default Single Product Page
* 
* Dupliquez ce fichier dans le en cours thème pour pouvoir le modifier
* 
* @since 0.1
*/

get_header(); ?>

    <!-- Main Content -->
    <div class="nine columns" role="content">
		
				<?php echo wp6tools_get_template_part( 'loop', 'single' ); ?>

    </div>
    <!-- End Main Content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>