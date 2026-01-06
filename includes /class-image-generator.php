<?php
if (!defined('ABSPATH')) exit;

class GAE_Image_Generator {

    public function gerar($post_id) {

        // Dados
        $nome     = get_post_meta($post_id, 'gae_nome', true);
        $cargo    = get_post_meta($post_id, 'gae_cargo', true);
        $tel      = get_post_meta($post_id, 'gae_telefone', true);
        $email    = get_post_meta($post_id, 'gae_email', true);
        $foto_id  = get_post_meta($post_id, 'gae_foto', true);

        // Caminhos
        $base = plugin_dir_path(__FILE__) . '../assets/fundo-assinatura.png';
        $font_bold = plugin_dir_path(__FILE__) . '../assets/Sora-Bold.ttf';
        $font_reg  = plugin_dir_path(__FILE__) . '../assets/Sora-Regular.ttf';

        // Abrir fundo
        $img = imagecreatefrompng($base);

        // Cores
        $azul = imagecolorallocate($img, 0, 81, 255);
        $cinza = imagecolorallocate($img, 51, 51, 51);
        $cinza2 = imagecolorallocate($img, 77, 77, 77);

        // ============================
        // 1. FOTO REDONDA — SEM DISTORCER
        // ============================
        $foto_path = get_attached_file($foto_id);

        if ($foto_path && file_exists($foto_path)) {

            $src = imagecreatefromstring(file_get_contents($foto_path));

            // tamanho final da foto
            $diametro = 292;

            // tamanho original
            $orig_w = imagesx($src);
            $orig_h = imagesy($src);

            // escala proporcional (object-fit: cover)
            $scale = max($diametro / $orig_w, $diametro / $orig_h);

            // novo tamanho proporcional
            $new_w = $orig_w * $scale;
            $new_h = $orig_h * $scale;

            // redimensionar mantendo proporção
            $resized = imagecreatetruecolor($new_w, $new_h);
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
            imagecopyresampled(
                $resized,
                $src,
                0, 0, 0, 0,
                $new_w, $new_h,
                $orig_w, $orig_h
            );

            // cortar o centro
            $crop_x = ($new_w - $diametro) / 2;
            $crop_y = ($new_h - $diametro) / 2;

            $temp = imagecreatetruecolor($diametro, $diametro);
            imagealphablending($temp, false);
            imagesavealpha($temp, true);
            $transp = imagecolorallocatealpha($temp, 0, 0, 0, 127);
            imagefill($temp, 0, 0, $transp);

            imagecopy(
                $temp,
                $resized,
                0, 0,
                $crop_x, $crop_y,
                $diametro, $diametro
            );

            // máscara circular
            $mask = imagecreatetruecolor($diametro, $diametro);
            imagesavealpha($mask, true);
            imagefill($mask, 0, 0, $transp);
            $white = imagecolorallocatealpha($mask, 255, 255, 255, 0);
            imagefilledellipse($mask, $diametro/2, $diametro/2, $diametro, $diametro, $white);

            // aplicar máscara
            $circular = imagecreatetruecolor($diametro, $diametro);
            imagealphablending($circular, false);
            imagesavealpha($circular, true);
            imagefill($circular, 0, 0, $transp);

            for ($x = 0; $x < $diametro; $x++) {
                for ($y = 0; $y < $diametro; $y++) {

                    $alpha = (imagecolorat($mask, $x, $y) >> 24) & 0x7F;

                    $rgb = imagecolorat($temp, $x, $y);
                    $r = ($rgb >> 16) & 0xFF;
                    $g = ($rgb >> 8) & 0xFF;
                    $b = $rgb & 0xFF;

                    imagesetpixel(
                        $circular,
                        $x, $y,
                        imagecolorallocatealpha($circular, $r, $g, $b, $alpha)
                    );
                }
            }

            // posição final da foto (VOCÊ DEFINIU)
            $pos_x = 604;
            $pos_y = 79;

            imagecopy($img, $circular, $pos_x, $pos_y, 0, 0, $diametro, $diametro);
        }

        // ============================
        // 2. TEXTO AJUSTADO
        // ============================

        imagettftext($img, 38, 0, 975, 155, $azul, $font_bold, $nome);
        imagettftext($img, 22, 0, 975, 200, $cinza, $font_reg, $cargo);
        imagettftext($img, 18, 0, 1015, 280, $cinza2, $font_reg, $tel);
        imagettftext($img, 18, 0, 1015, 320, $cinza2, $font_reg, $email);

        // ============================
        // EXPORTAR
        // ============================
        header('Content-Type: image/png');
        imagepng($img);
        imagedestroy($img);
    }
}
