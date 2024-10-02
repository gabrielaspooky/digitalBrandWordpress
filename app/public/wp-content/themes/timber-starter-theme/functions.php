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

        parent::__construct();
    }

    // Registrar tipos de contenido personalizados.
    public function register_custom_post_types() {
        register_post_type('about', array( // <-- 'about' en minúsculas
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
}

// Enqueue de Tailwind CSS.
function enqueue_theme_styles() {
    wp_enqueue_style( 'tailwind', get_template_directory_uri() . '/assets/css/tailwind.css', array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_theme_styles' );

// Renderizado de plantillas basado en la página actual.
function setup_page_views() {
    if (is_singular('about')) { // <-- Verificar si es el custom post type 'about'
        Timber::render('about.twig'); // <-- Renderiza 'about.twig'
    } elseif (is_page('index')) {
        Timber::render('index.twig');
    } elseif (is_page('author')) {
        Timber::render('author.twig');
    } elseif (is_page('menu')) {
        Timber::render('menu.twig');
    } elseif (is_page('footer')) {
        Timber::render('footer.twig');
    } else {
        Timber::render('404.twig');
    }
}
add_action('setup_page_views', 'template_redirect'); // <-- Usar 'template_redirect'

// Inicializar la clase para cargar Timber en tu tema.
new MyTheme();
