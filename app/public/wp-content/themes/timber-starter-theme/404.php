<?php
/**
 * The template for displaying 404 pages (Not Found)
 */

$context = Timber::context();
$context['message'] = "Lo sentimos, no encontramos lo que estás buscando.";

Timber::render( '404.twig', $context );