<?php
/**
* Default Loop Taxonomy
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
                        <h2><a href="<?php the_permalink(); ?>" class="th" title="<?php the_title_attribute(); ?>" ><?php the_title(); ?></a></h2>
                    </header>

                    <?php if ( has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" class="th" title="<?php the_title_attribute(); ?>" ><?php the_post_thumbnail(); ?></a>
                    <?php endif; ?>

                    <div class="content">
                       <?php echo wp6tools_get_meta('description'); ?>
                    </div>

                    <?php the_content(); ?>

                    <footer>


                    </footer>

            </article>

    <?php endwhile; ?>
<?php endif; ?>