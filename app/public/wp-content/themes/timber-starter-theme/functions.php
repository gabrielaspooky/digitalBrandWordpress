<?php
// Verificar si la clase Timber está disponible.
if ( ! class_exists( 'Timber' ) ) {
    add_action( 'admin_notices', function() {
        echo '<div class="error"><p>Timber no está activado. Asegúrate de activar el plugin Timber.</p></div>';
    } );
    return;
}

// Definir directorios de plantillas para Timber.
Timber::$dirname = array('templates', 'views');

class MyTheme extends Timber\Site {
    // Constructor de la clase para configurar el tema.
    public function __construct() {
        // Añadir soporte para características de WordPress.
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'menus' );

        // Iniciar hooks de acciones y filtros personalizados si es necesario.
        add_action( 'init', array( $this, 'register_custom_post_types' ) );
        add_action( 'init', array( $this, 'register_custom_taxonomies' ) );

        parent::__construct();
    }

    // Registrar tipos de contenido personalizados (si es necesario).
    public function register_custom_post_types() {
        // Añadir tipos de contenido personalizados aquí.
    }

    // Registrar taxonomías personalizadas (si es necesario).
    public function register_custom_taxonomies() {
        // Añadir taxonomías personalizadas aquí.
    }
}

// Inicializar la clase para cargar Timber en tu tema.
new MyTheme();
