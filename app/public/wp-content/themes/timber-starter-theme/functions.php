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

        // Registrar Custom Post Types y Taxonomías.
        add_action( 'init', array( $this, 'register_custom_post_types' ) );
        add_action( 'init', array( $this, 'register_custom_taxonomies' ) );

        // Lógica de renderizado para plantillas.
        add_action( 'template_redirect', array( $this, 'setup_page_views' ) );

        parent::__construct();
    }

    // Registrar tipos de contenido personalizados.
    public function register_custom_post_types() {
        register_post_type('about', array(
            'labels' => array(
                'name' => __('About'),
                'singular_name' => __('About Description')
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'about'),
            'supports' => array('title', 'editor', 'thumbnail'),
        ));
    }

    // Registrar taxonomías personalizadas (si es necesario).
    public function register_custom_taxonomies() {
        // Añadir taxonomías personalizadas aquí si las necesitas.
    }

    // Lógica para renderizar diferentes plantillas según el tipo de contenido.
    public function setup_page_views() {
        // Asegúrate de que Timber solo renderiza una vez.
        if ( is_singular('about') ) {
            Timber::render('about.twig');
            exit; // Detiene la ejecución para evitar renderizados adicionales
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
            Timber::render('404.twig');
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
