<?php
if (!defined('ABSPATH')) exit;

class GAE_Form_Handler {

    public function __construct() {
        add_action('init', [$this, 'processar_form']);
    }

    public function processar_form() {

        if (!isset($_POST['gae_submit'])) return;
        if (!isset($_POST['gae_nonce']) || !wp_verify_nonce($_POST['gae_nonce'], 'gae_nova_assinatura')) return;

        error_log("FORM RECEBIDO - Iniciando processamento...");

        // Upload seguro da foto
        $foto_id = 0;

        if (!empty($_FILES['gae_foto']['name'])) {

            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');
            require_once(ABSPATH . 'wp-admin/includes/image.php');

            $foto_id = media_handle_upload('gae_foto', 0);

            if (is_wp_error($foto_id)) {
                error_log("ERRO NO UPLOAD DE FOTO: " . $foto_id->get_error_message());
                $foto_id = 0; // evita erro fatal
            }
        }

        // Criar post
        $post_id = wp_insert_post([
            'post_title'  => 'Assinatura - ' . sanitize_text_field($_POST['gae_nome']),
            'post_type'   => 'assinatura',
            'post_status' => 'publish',
        ]);

        update_post_meta($post_id, 'gae_nome', sanitize_text_field($_POST['gae_nome']));
        update_post_meta($post_id, 'gae_cargo', sanitize_text_field($_POST['gae_cargo']));
        update_post_meta($post_id, 'gae_telefone', sanitize_text_field($_POST['gae_telefone']));
        update_post_meta($post_id, 'gae_email', sanitize_email($_POST['gae_email']));
        update_post_meta($post_id, 'gae_foto', $foto_id);

        // Redirecionamento seguro
        $redirect = wp_get_referer();
        if (!$redirect) {
            $redirect = home_url($_SERVER['REQUEST_URI']);
        }

        wp_redirect(add_query_arg(['assinatura_id' => $post_id], $redirect));
        exit;
    }
}
