<?php
/**
 * Plugin Name:       Gerador de Assinatura de E-mail
 * Plugin URI:        https://portifolio-profissional-eta.vercel.app/
 * Description:       Cria assinaturas de e-mail personalizadas e gera uma imagem dinamicamente com PHP.
 * Version:           1.1.0
 * Author:            Ary Passos
 * Author URI:        https://portifolio-profissional-eta.vercel.app/
 * License:           GPL v2 or later
 * Text Domain:       gerador-assinatura
 */

if (!defined('ABSPATH')) exit;

// Autoload simples das classes
require_once plugin_dir_path(__FILE__) . 'includes/class-cpt.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-endpoint.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-image-generator.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-shortcodes.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-form-handler.php';

// Inicialização
add_action('plugins_loaded', function() {
    new GAE_CPT();
    new GAE_Endpoint();
    new GAE_Shortcodes();
    new GAE_Form_Handler();
});
