# Gerador de Assinatura de E-mail

Plugin WordPress para criação de assinaturas de e-mail personalizadas, com geração dinâmica de imagem via PHP.

## Descrição

O Gerador de Assinatura de E-mail permite criar assinaturas padronizadas a partir de dados preenchidos em um formulário, gerando automaticamente uma imagem pronta para uso em clientes de e-mail.

A imagem base da assinatura e as fontes utilizadas estão localizadas na pasta `assets`. A posição de cada informação exibida na imagem é definida manualmente no código, permitindo total controle do layout final.

## Funcionalidades

- Criação de assinaturas de e-mail personalizadas
- Geração dinâmica de imagem utilizando PHP (GD)
- Shortcode para exibição do formulário
- Endpoint dedicado para geração da imagem
- Uso de fontes personalizadas
- Estrutura orientada a objetos (OOP)

## Estrutura do Plugin

gerador-assinatura-email/
├── assets/
│ ├── fundo-assinatura.png
│ ├── Sora-Bold.ttf
│ └── Sora-Regular.ttf
├── includes/
│ ├── class-cpt.php
│ ├── class-endpoint.php
│ ├── class-form-handler.php
│ ├── class-image-generator.php
│ └── class-shortcodes.php
├── gerador-assinatura-email.php
└── readme.md

markdown
Copiar código

## Requisitos

- WordPress 5.8 ou superior
- PHP 7.4 ou superior
- Extensão GD habilitada

## Instalação

1. Clone ou baixe o repositório:
git clone https://github.com/AryPassos/Plugin-gerador-de-assinatura/

arduino
Copiar código
2. Copie a pasta do plugin para:
wp-content/plugins/

perl
Copiar código
3. Ative o plugin no painel administrativo do WordPress

## Uso

Após ativar o plugin, utilize o shortcode abaixo em páginas ou posts:

[gerador_assinatura_email]

nginx
Copiar código

O formulário permitirá o preenchimento dos dados e a geração automática da imagem da assinatura.

## Customização da Imagem

A personalização da assinatura é feita no arquivo:

includes/class-image-generator.php

perl
Copiar código

Nesse arquivo devem ser configurados:

- O arquivo da imagem base localizado na pasta `assets`
- As fontes TrueType utilizadas
- As coordenadas X e Y de cada dado exibido na imagem
- Tamanho, cor e alinhamento dos textos

Cada informação do formulário é posicionada manualmente por coordenadas, garantindo precisão total no layout final da assinatura.

## Arquitetura

O plugin é inicializado no hook `plugins_loaded` e carrega as classes manualmente:

- GAE_CPT
- GAE_Endpoint
- GAE_Shortcodes
- GAE_Form_Handler
- GAE_Image_Generator

## Versão

1.1.0

## Autor

Ary Passos  
https://portifolio-profissional-eta.vercel.app/

## Licença

GPL v2 ou posterior