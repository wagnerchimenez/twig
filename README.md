# Exemplo minimalista com Twig

Projeto didático em PHP que demonstra, com uma aplicação pequena, como usar o [Twig](https://twig.symfony.com/) para criar templates reutilizáveis.

O exemplo demonstra `extends`, `include`, passagem de variáveis, filtros, macros e `embed`.

## Requisitos

- [Docker](https://docs.docker.com/get-docker/);
- Docker Compose;
- GNU Make (opcional).

O ambiente usa PHP 8.5 com Apache e instala o Twig por meio do Composer.

## Como executar

Na raiz do projeto:

```bash
make setup
```

O comando instala as dependências e inicia os containers. A aplicação fica disponível em:

- [Página inicial](http://localhost:8080/index.php)
- [Sobre](http://localhost:8080/sobre.php)
- [Contato](http://localhost:8080/contato.php)

Para controlar o ambiente:

```bash
make up
make down
```

Sem `make`, use:

```bash
docker compose run --rm composer install
docker compose up -d
```

## Publicação no GitHub Pages

O workflow [`pages.yml`](.github/workflows/pages.yml) gera uma versão HTML estática do projeto e publica no GitHub Pages.

Ative **Settings → Pages → GitHub Actions** no repositório. A página ficará disponível em:

https://wagnerchimenez.github.io/twig/

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

## Conceitos demonstrados

- `extends` e `block`: layout compartilhado em `template.twig`;
- `include`: menu reutilizável;
- variáveis: `usuario` enviado pelo PHP;
- filtros: `capitalize` nos campos do formulário;
- macros: inputs e botão em `formulario.twig`;
- `embed`: card personalizado na página de contato.

O formulário é apenas demonstrativo e não processa os dados enviados.
