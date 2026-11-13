# Exemplo minimalista com Twig

Projeto didático em PHP que demonstra, com uma aplicação pequena, como usar o [Twig](https://twig.symfony.com/) para criar templates reutilizáveis.

O exemplo demonstra `extends`, `include`, passagem de variáveis, filtros, macros e `embed`.

## Como executar

```bash
make setup
make up
make down
```
Aplicação: http://localhost:8080/index.php

## Estrutura

```text
.
├── compose.yaml             # Serviços PHP/Apache e Composer
├── Makefile                 # Comandos de instalação e execução
└── src/
    ├── composer.json        # Dependência do Twig
    ├── index.php            # Renderiza index.twig com usuario
    ├── sobre.php            # Renderiza sobre.twig
    ├── contato.php          # Renderiza contato.twig
    └── views/
        ├── template.twig    # Layout base e bloco conteudo
        ├── index.twig       # Página inicial
        ├── sobre.twig       # Página Sobre
        ├── contato.twig     # Página com embed e macros
        └── componentes/
            ├── menu.twig
            ├── card.twig
            └── formulario.twig
```
