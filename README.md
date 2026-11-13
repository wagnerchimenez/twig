# Exemplo minimalista com Twig

Projeto didático em PHP que demonstra, com uma aplicação pequena, como usar o [Twig](https://twig.symfony.com/) para criar templates reutilizáveis.

O exemplo cobre herança com `extends`/`block`, componentes com `include`, passagem de variáveis, macros e composição com `embed`.

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

O GitHub Pages publica arquivos estáticos e não executa PHP no servidor. Por isso, o workflow [`pages.yml`](.github/workflows/pages.yml) renderiza os templates Twig durante o GitHub Actions e publica os arquivos HTML gerados.

Depois do primeiro push, em **Settings → Pages**, selecione **GitHub Actions** como fonte de publicação. O site ficará disponível em:

```text
https://wagnerchimenez.github.io/twig/
```

O deploy é executado automaticamente a cada push na branch `main`.

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

### Inicialização e variáveis

Cada endpoint carrega o autoloader, configura um `FilesystemLoader` para `src/views` e renderiza um template. A página inicial passa `usuario` para o Twig:

```php
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/views');
$twig = new \Twig\Environment($loader);

echo $twig->render('index.twig', [
    'usuario' => 'Wagner Lima Chimenez',
]);
```

No template, a variável é exibida com `{{ usuario }}`.

### Herança com `extends`

`template.twig` define a estrutura comum e o bloco `conteudo`. As páginas usam `extends` para preencher esse bloco:

```twig
{% extends 'template.twig' %}

{% block conteudo %}
    Conteúdo específico da página
{% endblock %}
```

### Componentes com `include`

O menu fica em um arquivo próprio e é reutilizado nas páginas:

```twig
{% include 'componentes/menu.twig' %}
```

### Macros

`componentes/formulario.twig` define macros semelhantes a funções. Em `contato.twig`, eles são importados com um alias:

```twig
{% import 'componentes/formulario.twig' as formulario %}

{{ formulario.input('nome') }}
{{ formulario.submit('enviar') }}
```

### Composição com `embed`

`contato.twig` reutiliza `componentes/card.twig` e sobrescreve seu bloco `conteudo` com o formulário:

```twig
{% embed 'componentes/card.twig' %}
    {% block conteudo %}
        Conteúdo personalizado
    {% endblock %}
{% endembed %}
```

## Fluxo de renderização

```text
endpoint PHP → template.twig → página específica
                              ├── include: menu.twig
                              └── contato.twig
                                  ├── embed: card.twig
                                  └── import: formulario.twig
```

## Observações

Este é um exemplo educacional. O formulário usa `method="post"`, mas não há processamento nem persistência dos dados enviados.

## Referências

- [Documentação oficial do Twig 3.x](https://twig.symfony.com/doc/3.x/)
- [Herança de templates](https://twig.symfony.com/doc/3.x/templates.html#template-inheritance)
- [Inclusão de templates](https://twig.symfony.com/doc/3.x/templates.html#including-other-templates)
- [Macros](https://twig.symfony.com/doc/3.x/tags/macro.html)
- [Tag `embed`](https://twig.symfony.com/doc/3.x/tags/embed.html)
- [Boas práticas para README no GitHub](https://docs.github.com/en/repositories/managing-your-repositorys-settings-and-features/customizing-your-repository/about-readmes)
