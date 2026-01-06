<?php
if (!defined('ABSPATH')) exit;

class GAE_Endpoint {

    public function __construct() {

        // Registra o rewrite do endpoint
        add_action('init', [$this, 'registrar_rewrite']);

        // Adiciona query var
        add_filter('query_vars', [$this, 'registrar_query_vars']);

        // Render da imagem (corrigido)
        add_action('template_redirect', [$this, 'render_image']);
    }

    /**
     * Cria a URL amigável:
     * /gerar-assinatura/123/
     */
    public function registrar_rewrite() {
        add_rewrite_rule(
            '^gerar-assinatura/([0-9]+)/?$',
            'index.php?gerar_assinatura_id=$matches[1]',
            'top'
        );
    }

    /**
     * Registra variáveis
     */
    public function registrar_query_vars($vars) {
        $vars[] = 'gerar_assinatura_id';
        return $vars;
    }

 
    public function render_image() {

        $id = get_query_var('gerar_assinatura_id');

        if (!$id) {
            return; 
        }

        while (ob_get_level()) {
            ob_end_clean();
        }

        $generator = new GAE_Image_Generator();
        $generator->gerar($id);

        exit;
    }
}
