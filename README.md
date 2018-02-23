# php-diff

Highlight diffs provided by Sebastian Bergmann diff

[![Build Status](https://travis-ci.org/sokil/php-diff.svg?branch=master)](https://travis-ci.org/sokil/php-diff)
[![Coverage Status](https://coveralls.io/repos/github/sokil/php-diff/badge.svg?branch=master&1)](https://coveralls.io/github/sokil/php-diff?branch=master)

## Installation

```
composer.phar require sokil/php-diff
```

## Useage

```php
<?php

use Sokil\Diff\Change;
use Sokil\Diff\Renderer;

$diffRenderer = new Renderer();
$actualDiff = $diffRenderer->render(new Change(
    implode(PHP_EOL, ['line1', 'line2', 'line3']),
    implode(PHP_EOL, ['line1', 'line2changed', 'line3'])
));

```

## Format of diff output

Format of diff tags may be configured. By default renders only two tags: `<ins>` and `<del>`. To 
highlight output, use predefined format:

```php
<?php
$renderer = new Renderer([
    'format' => Renderer::FORMAT_COLOUR
]);
```

This will produce following HTML:

```html
line1
<del style="background: #ffe7e7;">line2</del>
<ins style="background: #ddfade;">line2changed</ins>
line3
```

To fully customize style, use next syntax (this format has alias `Renderer::FORMAT_COLOUR`):

```php
<?php
$renderer = new Renderer([
    'format' => [
        'insert' => [
            'tag' => 'ins',
            'attributes' => 'style="background: #ddfade;"',
        ],
        'delete' => [
            'tag' => 'del',
            'attributes' => 'style="background: #ffe7e7;"',
        ]
    ]
]);

// this is same to
$renderer = new Renderer([
    'format' => Renderer::FORMAT_COLOUR
]);
```

Default format `Renderer::FORMAT_DEFAULT` has following notation:

```php
<?php
$renderer = new Renderer([
    'insert' => [
        'tag' => 'ins',
    ],
    'delete' => [
        'tag' => 'del',
    ]
]);

// this is same to
$renderer = new Renderer([
    'format' => Renderer::FORMAT_DEFAULT
]);
```

You can omit any 
