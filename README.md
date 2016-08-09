# php-diff

Highlight diffs provided by Sebastian Bergmann diff

## Installation

```
composer.phar require sokil/php-diff
```

## Useage

```php
<?php

$diffRenderer = new Renderer();
$actualDiff = $diffRenderer->render(
    implode(PHP_EOL, ['line1', 'line2', 'line3']),
    implode(PHP_EOL, ['line1', 'line2changed', 'line3'])
);

```
