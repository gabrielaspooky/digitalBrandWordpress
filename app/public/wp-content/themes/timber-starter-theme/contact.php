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

// Registrar Custom Post Types y Taxonomías, si es necesario.
class MyTheme extends Timber\Site {
    public function __construct() {
        parent::__construct();

        // Registrar la acción para procesar el formulario.
        add_action('template_redirect', array($this, 'process_contact_form'));
    }

    // Procesar el formulario de contacto
    public function process_contact_form() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['email'], $_POST['message'])) {
            $context = Timber::context();

            $name = sanitize_text_field($_POST['name']);
            $email = sanitize_email($_POST['email']);
            $message = sanitize_textarea_field($_POST['message']);

            // Validación simple
            if ( empty($name) || empty($email) || empty($message) ) {
                $context['form_error'] = "All fields are required.";
            } elseif ( !is_email($email) ) {
                $context['form_error'] = "Please enter a valid email address.";
            } else {
                // Simular el envío de un correo electrónico (aquí agregarías la función mail() si es necesario)
                $to = get_option('admin_email');
                $subject = "New Contact Form Message from " . $name;
                $headers = array('Content-Type: text/html; charset=UTF-8', 'From: ' . $email);

                $mail_sent = wp_mail($to, $subject, $message, $headers);

                if ($mail_sent) {
                    $context['form_success'] = "Thank you! Your message has been sent.";
                } else {
                    $context['form_error'] = "Sorry, your message couldn't be sent. Please try again.";
                }
            }

            // Renderizar la plantilla con el contexto actualizado
            Timber::render('contact.twig', $context);
            exit;
        }
    }
}

// Inicializar el tema.
new MyTheme();
