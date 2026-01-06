<?php
if (!defined('ABSPATH')) exit;

class GAE_Shortcodes {

    public function __construct() {
        add_shortcode('gerador_assinatura_formulario', [$this, 'form']);
        add_shortcode('assinatura_preview', [$this, 'preview']);
    }

    /**
     * Shortcode do Formulário
     */
    public function form() {

        // Processamento é disparado automaticamente pelo Form Handler
        ob_start(); ?>

        <form id="gae-form" method="post" enctype="multipart/form-data" style="max-width:500px;">
            
            <?php wp_nonce_field('gae_nova_assinatura', 'gae_nonce'); ?>

            <p>
                <label>Nome Completo:<br>
                <input type="text" name="gae_nome" required style="width:100%;"></label>
            </p>

            <p>
                <label>E-mail:<br>
                <input type="email" name="gae_email" required style="width:100%;"></label>
            </p>

            <p>
                <label>Telefone:<br>
                <input type="text" name="gae_telefone" required style="width:100%;"></label>
            </p>

            <p>
                <label>Cargo:<br>
                <input type="text" name="gae_cargo" required style="width:100%;"></label>
            </p>

            <p>
                <label>Foto:<br>
                <input type="file" name="gae_foto" accept="image/*" required></label>
            </p>

            <p>
                <input type="submit" name="gae_submit" value="Gerar Assinatura" 
                       style="background:#0051FF;color:#fff;border:none;padding:12px 22px;border-radius:6px;cursor:pointer;">
            </p>

        </form>

        <?php
        return ob_get_clean();
    }


    /**
     * Shortcode de Preview da Assinatura
     * Exibe o resultado ao lado do formulário
     */
    public function preview() {

        if (!isset($_GET['assinatura_id'])) {
            return '<div class="assinatura-preview" style="padding:20px; color:#aaa;">A assinatura aparecerá aqui após gerar.</div>';
        }

        $id  = intval($_GET['assinatura_id']);
        $url = home_url('/gerar-assinatura/' . $id);

        ob_start(); ?>

        <div class="assinatura-preview" style="padding:20px;">
            <h3>Sua assinatura foi gerada com sucesso!</h3>

            <img src="<?= esc_url($url) ?>" 
                 alt="Assinatura Gerada" 
                 style="max-width:100%; border-radius:6px; margin:20px 0;">

            <a download="assinatura.png" 
               href="<?= esc_url($url) ?>"
               style="
                    background:#0051FF;
                    color:white;
                    padding:12px 22px;
                    border-radius:6px;
                    display:inline-block;
                    text-decoration:none;
               ">
                Baixar Assinatura
            </a>
        </div>

        <?php
        return ob_get_clean();
    }
}
