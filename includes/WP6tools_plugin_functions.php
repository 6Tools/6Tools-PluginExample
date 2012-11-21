<?php
/**
* Fonctions du plugin
*
* @package 6Tools Project
* @subpackage 6Catalog Plugin
* @since 0.1
*/


/**
* Fonction retourne meta value si elle existe
* @param string $key meta_value key 
* @return string meta_value
*/
function wp6tools_get_meta( $key ){

    $m = get_post_meta( get_the_ID() , WP6tools::$textdomain . "_". $key, true);
    
    if( !empty( $m ) )  return $m;
}


/**
* Retourne un fichier template du plugin si il existe
* @param string $slug
* @param string $name
*/
function wp6tools_get_template_part( $slug, $name = '' ) {
        
        $tpl_path = SIXTOOLS_DIR . '/templates/wp6tools_' . $slug . '-' . $name . '.php';
        
        if(file_exists( $tpl_path ))
            load_template( $tpl_path );
        else
            get_template_part($slug);
}

/**
* Retourne un slideshow avec les images liées au produit
* @return slideshow
*/
function wp6tools_get_slideshow(){
    
    $images = rwmb_meta( WP6tools::$textdomain . '_pictures', 'type=image' );
    
    if(count($images) < 1) return;
    ?>

    <div class='wp6tools_slideshow'>
        
        <?php foreach ( $images as $image ) : ?>
            <img src='<?php echo $image['url']; ?>' width='<?php echo $image['width']; ?>' height='<?php echo $image['height']; ?>' alt='<?php echo $image['alt']; ?>' />
        <?php endforeach; ?>
             
    </div>
    <?php
}


?>