<?php
/**
 * Plugin 6Tools
 * 
 * @package 6Tools Project
 * @subpackage 6Catalog Plugin
 * @author mOveo <gaetan@moveo-webdesign.com>
 * @since 0.1
 */

/*
 * Ce plugin de base de développement intègre les fonctions :
 * 
 * - Creation des post-types et taxonomies
 * - Intégration de la librairy RW_Meta_Boxes
 * - Ajout d'un shortcode
 * - Fonctions d'activation, désactivation et desinstallation du plugin
 * - Ajout d'un widget
 * - Ajout d'un menu de configuration du widget dans le menu admin
 * @todo Créer fichiers de lang FR_fr
 * 
 */

class WP6tools
{
             
        /**
         * Post-type de la classe
         * @var string 
         */
        public static $posttype = "sixcatalog_product";
        
        /**
         * Text domain du plugin et slug
         * @var string 
         */
        public static $textdomain = "sixtools";
        
        /**
         * Nom du plugin
         * @var string 
         */
        public static $plugin_name;
        
        /**
         * Valeurs par défaut des options d'admin du plugin
         */
        public $admin_options_defaults = array(
            'option1' => "empty Option 1",
            'option2' => "empty Option 2",
            'option3' => "empty Option 3"
        );
        
        /**
         * Array contenant les paramètres des metabox de l'admin
         * @var Array 
         */
        var $metaboxes = array();
        
        
	/**
	 * Constructeur de la classe WP6tools
	 */
	public function __construct()
	{
            // Initialisation des variables
            self::$plugin_name = __("Catalogue 6Tools", WP6tools::$textdomain);
            
            // Initialisation du plugin
            add_action( 'init', array( &$this, 'init' ) );
            
            // Register activation, desactivation and uninstalltion hooks
            register_activation_hook( __FILE__, array( __CLASS__, 'activate' ) );
            register_deactivation_hook( __FILE__, array( __CLASS__, 'deactivate' ) );
            register_uninstall_hook( __FILE__, array( __CLASS__, 'uninstall' ) );
            
            // Include du/des widgets
            foreach(glob( SIXTOOLS_DIR . "/widgets/*.php" ) as $filename)  {
                include_once($filename);
            }
            add_action('widgets_init', array(&$this, 'register_widgets'));
	}
	
        
	 /**
	 * Initialisation du plugin
	 * Création des post-types, taxonomies
	 */
	public function init()
	{
                // Chargement du Text Domain
                load_plugin_textdomain(  WP6tools::$textdomain, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
                
                // Enregistrement des post-types
                register_post_type( WP6tools::$posttype , $this->get_plugin_posts_type());
                
                // Enregistrement des taxonimies
                register_taxonomy( WP6tools::$posttype . '_cat' , array( WP6tools::$posttype ), $this->get_plugin_taxonomies() );
                
                // Include de la librairie RW Meta Box
                require_once SIXTOOLS_DIR . '/lib/meta-box/meta-box.php';
                require_once SIXTOOLS_DIR . '/lib/meta-box/inc/helpers.php';
                require_once SIXTOOLS_DIR . '/lib/meta-box/meta-box.php';
                
                
                if( is_admin() ) {
                    
                     add_action( 'admin_init', array($this, 'on_admin_page'));
                     add_action( 'admin_menu', array($this, 'on_admin_menu'));
                    
                }else {
                    
                    $this->on_public_page();
                    
                }
	}
        
        
        /**
	 * Fonctions propres à la partie public du site (front)
	 * @todo Chargement des styles css du front spécifiques au plugin
	 */
        function on_public_page(){
            
            // Detection du template actuel de la page
            add_filter( 'template_include', array(&$this, 'template_loader'));
            
            // Ajout du shortcode du plugin
            add_shortcode('WP6tools_catalog', array($this, 'shortcode_catalog_function'));
            
        }
        
        
        /**
	 * Fonctions propres à l'admin
         * @todo Chargement des styles css de l'admin spécifiques au plugin
	 */
        function on_admin_page(){
           
            // Initialisation de array contenant les Metas Box
            $this->metaboxes = array();
            
            // Ajout des Metas Box dans la page admin
            $this->get_meta_boxes();
            
            // Déclaration des options du plugin
            // @todo Ajouter une fonction callback de validation et de nettoyage des données saisies
            register_setting( WP6tools::$textdomain . '_admin_options', WP6tools::$textdomain . '_admin_options' /*, TODO : validate_function */ );
            
        }
        
        /**
         * Fonctions liées aux options de l'admin
         */
        function on_admin_menu(){
            
            // Création d'un onglet supplémentaire dans le menu de l'admin
            add_options_page( WP6tools::$plugin_name, WP6tools::$plugin_name, 'manage_options', WP6tools::$textdomain . "_options", array( $this, 'admin_options_page' ) );
            
        }
        
        
        /**
	 * Fonction appelée lors de l'activation du plugin
         * @todo Ajouter actions liées à la désactivation du plugin
	 */
        public static function activate( $multi ){
            
            
        }  
        
        
        /**
	 * Fonction appelée lors de la désactivation du plugin
         * @todo Ajouter actions liées à la désactivation du plugin
	 */
        public static function desactivate( $multi ){
            
            
        }
        
        
        /**
	 * Fonction appelée lors de la désinstallation du plugin
         * @todo Ajouter actions liées à la désinstallation du plugin
	 */
        public static function uninstall( $multi ){
            
            
        }
        
        
        /**
	 * Déclaration des widgets du plugin
	 */
        function register_widgets() {
            register_widget('WP6toolsExample');
        }
        
        
        /**
         * Page admin du plugin
         */
        function admin_options_page(){
            
            if( !current_user_can( 'manage_options' ) ) {
                wp_die( __('You do not have sufficient permissions to access this page',  WP6tools::$textdomain ));
            }
            
            $namespace = WP6tools::$textdomain;
            $admin_options_slug = WP6tools::$textdomain . '_admin_options';

            include( SIXTOOLS_TPL_DIR . "/admin/admin_options.php" );
            
        }
        
        
        /**
         * Retourne la valeur de l'option passée en paramètre
         * @param string $opt Nom de l'option
         * @return string Valeur de l'option sinon chaine vide
         */
        function get_admin_option($opt){
            
            if( !isset( $this->options ) || empty( $this->options ) )
                $this->options = get_option( self::$textdomain . '_admin_options', $this->admin_options_defaults );

            $this->options = wp_parse_args($this->options);
            
            if( !isset($this->options[$opt]) )
                return $this->admin_options_defaults[$opt];
            
            return $this->options[$opt];
        }
        
        
        /**
	 * Templates loader
         * Détermine quel template intégré en fonction de la page en cours
	 * @return fichier .php à inclure
	 */
        function template_loader( $template ) {

            // On vérifie si on est sur une page simple et son post-type
            if ( is_single() && get_post_type() == WP6tools::$posttype ) {
                
                $template = locate_template( array( 'wp6tools_single.php', SIXTOOLS_TPL_DIR . 'wp6tools_single.php' ) );
                
                if ( ! $template ) $template = ( SIXTOOLS_TPL_DIR . '/wp6tools_single.php');
            
            // On vérifie si on est sur une page archive et sa taxinomie
            }elseif ( is_tax( WP6tools::$posttype . '_cat' ) ){
                
                $template = locate_template( array( 'wp6tools_taxonomy.php', SIXTOOLS_TPL_DIR . 'wp6tools_taxonomy.php' ) );
                
                if ( ! $template ) $template = ( SIXTOOLS_TPL_DIR . '/wp6tools_taxonomy.php');
                
            }
            return $template;
        }
        
        
        
        /**
	 * Shortcode pour afficher l'ensemble du catalogue
	 * @params TODO
	 */
        function shortcode_catalog_function($atts){
            
            // Extraction des paramètres entrés en argument
            extract(shortcode_atts(array( 
                
                'products_by_page'  => -1,
                'products_sort_by'  => 'title'
                
            ), $atts));
            
            return "Shortcode returns great result" ;
        }
        
        
        
        /**
	 * Enregistrement des post-types nécessaires au plugin
	 * @return Array Paramètres du Post type
	 */
        public function get_plugin_posts_type(){
            
            $labels = array(
			'name' 			=> __( 'Products', 'sixtools' ),
			'singular_name' 	=> __( 'Product', 'sixtools' ),
			'add_new' 		=> _x( 'Create New', 'Products', 'sixtools' ),
			'add_new_item' 		=> __( 'Register', 'sixtools' ),
			'edit_item' 		=> __( 'Edit Products Details', 'sixtools' ),
			'edit' 			=> _x( 'Edit', 'Products', 'sixtools' ),
			'new_item' 		=> __( 'New Product', 'sixtools' ),
			'view_item' 		=> __( 'View Product', 'sixtools' ),
			'search_items' 		=> __( 'Search Product', 'sixtools' ),
			'not_found' 		=> __( 'No product found', 'sixtools' ),
			'not_found_in_trash' 	=> __( 'No products found in trash', 'sixtools' )
		);

		$supports = array( 'title' );

		$args = array(
			'labels'		=> $labels,
			'description' 		=> __( 'Registration details for products', 'sixtools' ),
			'public' 		=> true,
			'show_ui'		=> true,
			'supports'		=> $supports,
			'menu_position' 	=> 30,
			'rewrite'		=> false,
			'hierarchical' 		=> true,  
			//'register_meta_box_cb'	=> 'register_meta_boxes',
		);
                
                
                return $args;
            
        }
        
        
        
        /**
	 * Enregistrement des taxonimies nécessaires au plugin
	 * @return  Array Paramètres des taxonimies
	 */
        public function get_plugin_taxonomies(){
            
		$tag_labels = array(
			'name'                          => __('Product category','sixtools'),
			'singular_name'                 => _x( 'Category', 'taxonomy singular name'),
			'search_items'                  =>  __( 'Search Category','sixtools'),
			'all_items'                     => __( 'All Categories','sixtools'),
			'popular_items'                 => __( 'Popular Categories','sixtools'),
			'parent_item'                   => null,
			'parent_item_colon'             => null,
			'edit_item'                     => __( 'Edit Category','sixtools'),
			'update_item'                   => __( 'Update Category','sixtools'),
			'add_new_item'                  => __( 'Add New Category','sixtools'),
			'new_item_name'                 => __( 'New Category Name','sixtools'),
			'not_found'                     =>  __('No Categories found','sixtools'),
			'choose_from_most_used'         => __( 'Choose from the most used categories','sixtools' ),
			'menu_name'                     => __( 'Categories' ),
			'add_or_remove_items'           => __( 'Add or remove categories','sixtools' ),
			'separate_items_with_commas'    => __( 'Separate categories with commas','sixtools' )
  		); 	

		$args = array(
			'hierarchical'              => true,
			'labels'                    => $tag_labels,
			'show_ui'                   => true,
			'update_count_callback'     => '_update_post_term_count',
			'query_var'                 => true,
			'public'                    => true,
                        'rewrite'                   => false
  		);
                
                return $args;
            
        }
        
        
        
        /**
	 * Ajout des meta-boxes dans l'admin
	 * Nécessite la librairie RW_Meta_Box
	 */
        function get_meta_boxes() {
                
                $prefix = WP6tools::$textdomain . "_";

                $this->metaboxes[] = array(
                        'id'		=> 'sixproduct',
                        'title'		=> __("Product details", "sixtools"),
                        'pages'		=> array( WP6tools::$posttype ),

                        'fields'	=> array(
                                // Description // WYSIWYG / Editor
                                array(
                                        'name'	=> __("Product description", "sixtools"),
                                        'id'	=> $prefix . 'description',
                                        'type'	=> 'wysiwyg',
                                        'desc'	=> __("", "sixtools")
                                ),
                                // Descriptif technique // WYSIWYG / Editor
                                array(
                                        'name'	=> __("Technical description", "sixtools"),
                                        'id'	=> $prefix . 'technical',
                                        'type'	=> 'wysiwyg',
                                        'desc'	=> __("", "sixtools")
                                ),                       
                                // Images // MultiUpload Manager
                                array(
                                        'name'	=> __("Product pictures", "sixtools") ,
                                        'desc'	=> __("", "sixtools"),
                                        'id'	=> $prefix . 'pictures',
                                        'type'	=> 'plupload_image',
                                        'max_file_uploads' => 4,
                                )
                        )
                );

                // On vérifie que la classe est bien chargée
                if ( class_exists( 'RW_Meta_Box' ) )
                {
                        foreach ( $this->metaboxes as $meta_box )
                        {
                                new RW_Meta_Box( $meta_box );
                        }
                }
        }
}

/**
 * Le plugin est lancé une fois tous les plugins chargés
 */
add_action( 'plugins_loaded', create_function('', 'return new WP6tools();') );
?>