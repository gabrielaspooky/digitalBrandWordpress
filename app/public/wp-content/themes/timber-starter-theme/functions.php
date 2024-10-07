<?php
// Verificar si la clase Timber está disponible.
if ( ! class_exists( 'Timber' ) ) {
    add_action( 'admin_notices', function() {
        echo '<div class="error"><p>Timber no está activado. Asegúrate de activar el plugin Timber.</p></div>';
    } );
    return;
}

// Definir directorios de plantillas para Timber.
Timber::$dirname = array('views');

class MyTheme extends Timber\Site {
    // Constructor de la clase para configurar el tema.
    public function __construct() {
        // Añadir soporte para características de WordPress.
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'menus' );

        add_action( 'init', array( $this, 'register_custom_post_types' ) );
        add_action( 'init', array( $this, 'register_custom_taxonomies' ) );

     
        add_action( 'template_redirect', array( $this, 'setup_page_views' ) );

        parent::__construct();
    }

 
    public function register_custom_post_types() {
        register_post_type('about', array(
            'labels' => array(
                'name' => __('About'),
                'singular_name' => __('About Description'),
                'add_new' => __('Add New'),
                'add_new_item' => __('Add New About Description'),
                'edit_item' => __('Edit About Description'),
                'new_item' => __('New About Description'),
                'view_item' => __('View About Description'),
                'search_items' => __('Search About Descriptions'),
                'not_found' => __('No About Descriptions found'),
                'not_found_in_trash' => __('No About Descriptions found in Trash'),
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'about'),
            'supports' => array('title', 'editor', 'thumbnail'),
        ));
    }

  
    public function register_custom_taxonomies() {
        
    }

    public function setup_page_views() {
   
        if ( is_singular('about') ) {
            Timber::render('about.twig');
            exit; 
        } elseif ( is_home() || is_front_page() ) {
            Timber::render('index.twig');
            exit;
        } elseif ( is_page('services') ) {
            Timber::render('services.twig');
            exit;
        } elseif ( is_page('contact') ) {
            Timber::render('contact.twig');
            exit;
        } else {
            Timber::render('services.twig');
            exit;
        }
    }
}

// Enqueue de Tailwind CSS.
function enqueue_theme_styles() {
    wp_enqueue_style( 'tailwind', get_template_directory_uri() . '/assets/css/tailwind.css', array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_theme_styles' );

// Inicializar la clase del tema.
new MyTheme();
