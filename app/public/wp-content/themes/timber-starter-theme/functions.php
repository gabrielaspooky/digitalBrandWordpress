<?php

// Verificar si la clase Timber está disponible.
if ( ! class_exists( 'Timber' ) ) {
    add_action( 'admin_notices', function() {
        echo '<div class="error"><p>Timber no está activado. Asegúrate de activar el plugin Timber.</p></div>';
    } );
    return;
}

// Directorio donde buscar las vistas de Timber
Timber::$dirname = array('views');

// Definir la clase principal del tema
class MyTheme extends Timber\Site {

    public function __construct() {
        // Habilitar soporte para thumbnails y menús en el tema
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'menus' );

        // Hooks para registrar tipos de posts y taxonomías personalizadas
        add_action( 'init', array( $this, 'register_custom_post_types' ) );
        add_action( 'init', array( $this, 'register_custom_taxonomies' ) );

        // Hook para manejar las plantillas de Timber en función de las vistas
        add_action( 'template_redirect', array( $this, 'setup_page_views' ) );

        parent::__construct();
    }

    // Registro de un custom post type llamado 'About'
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

    // Registro de taxonomías personalizadas (a completar según necesidad)
    public function register_custom_taxonomies() {
        register_taxonomy('about_category', 'about', array(
            'labels' => array(
                'name' => __('About Categories'),
                'singular_name' => __('About Category'),
            ),
            'hierarchical' => true,
            'public' => true,
            'rewrite' => array('slug' => 'about-category'),
        ));
    }

    // Definir cómo manejar las plantillas en función de las vistas
    public function setup_page_views() {
        $context = Timber::get_context(); // Obtener el contexto general

        if ( is_singular('about') ) {
            Timber::render('about.twig', $context);
            exit;
        } elseif ( is_home() || is_front_page() ) {
            Timber::render('index.twig', $context);
            exit;
        } elseif ( is_page('services') ) {
            Timber::render('services.twig', $context);
            exit;
        } elseif ( is_page('contact') ) {
            Timber::render('contact.twig', $context);
            exit;
        } else {
            error_log('No se encontró ninguna coincidencia: ' . print_r(get_queried_object(), true));
            Timber::render('base.twig', $context);
            exit;
        }
    }
}

// Encolar estilos (Tailwind CSS en este caso)
function enqueue_theme_styles() {
    wp_enqueue_style( 'tailwind', get_template_directory_uri() . '/assets/css/tailwind.css', array(), false, 'all' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_theme_styles' );

// Instancia de la clase del tema
new MyTheme();

// Añadir datos globales al contexto de Timber
function add_to_context( $context ) {
    // Menú principal
    $context['menu'] = new Timber\Menu();
    // Datos del sitio
    $context['site'] = new Timber\Site();
    // Otras variables globales (ej. URL de inicio, assets)
    $context['home_url'] = home_url();
    $context['assets'] = get_template_directory_uri() . '/assets';
    
    return $context;
}
add_filter( 'timber/context', 'add_to_context' );

// Añadir reglas de reescritura personalizadas
function add_theme_routes() {
    add_rewrite_rule('^about/?$', 'index.php?pagename=about', 'top');
    add_rewrite_rule('^services/?$', 'index.php?pagename=services', 'top');
}
add_action('init', 'add_theme_routes');

// Vaciar reglas de reescritura al activar el tema para asegurar que se apliquen
function flush_rewrite_rules_on_activation() {
    add_theme_routes();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'flush_rewrite_rules_on_activation' );