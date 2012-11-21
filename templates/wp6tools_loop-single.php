<?php
/**
* Default Loop Single
* 
* Dupliquez ce fichier dans le en cours thème pour pouvoir le modifier
* 
* @since 0.1
*/
?>

<?php if ( have_posts() ) : ?>

        <?php while ( have_posts() ) : the_post(); ?>

<article>

	<header>
		<hgroup>
			<h2><?php the_title(); ?></h2>
                        <p>Catégories : <?php
                            $terms = get_the_terms( $post->ID , 'sixcatalog_product_cat' );
                            foreach ( $terms as $term ) : ?>
                            <a href="<?php echo get_term_link($term->slug, 'sixcatalog_product_cat'); ?>"><?php echo $term->name; ?></a> 
                            <?php 
                            endforeach;
                            ?>
                        </p>
		</hgroup>
	</header>
    
        <hr/>

	<?php if ( has_post_thumbnail()) : ?>
	<a href="<?php the_permalink(); ?>" class="th" title="<?php the_title_attribute(); ?>" ><?php the_post_thumbnail(); ?></a>
	<?php endif; ?>
	
        <div class="content">
            <?php echo wp6tools_get_meta('description'); ?>
            
        </div>
        
	<?php the_content(); ?>

	<footer>
         
  
            <dl class="tabs contained">
              <dd class="active"><a href="#simpleContained1">Pictures</a></dd>
              <dd class="hide-for-small"><a href="#simpleContained2">Technical details</a></dd>
              <dd class="hide-for-small"><a href="#simpleContained3">+</a></dd>
            </dl>
            <ul class="tabs-content contained">
              <li class="active" id="simpleContained1Tab"><?php wp6tools_get_slideshow(); ?></li>
              <li id="simpleContained2Tab"><?php echo wp6tools_get_meta('technical'); ?></li>
              <li id="simpleContained3Tab">...</li>
            </ul>

	</footer>
        

</article>

<?php endwhile; ?>
			
<?php endif; ?>