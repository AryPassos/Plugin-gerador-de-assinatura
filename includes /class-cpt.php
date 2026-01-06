<?php
if (!defined('ABSPATH')) exit;

class GAE_CPT {

    public function __construct() {
        add_action('init', [$this, 'registrar_cpt']);
    }

    public function registrar_cpt() {

        $args = [
            'label'         => 'Assinaturas',
            'public'        => true,
            'menu_icon'     => 'dashicons-id-alt',
            'show_ui'       => true,
            'supports'      => ['title'],
            'rewrite'       => ['slug' => 'assinatura'],
        ];

        register_post_type('assinatura', $args);
    }
}
