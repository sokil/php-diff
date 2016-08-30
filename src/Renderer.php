<?php

namespace Sokil\Diff;

use SebastianBergmann\Diff\Differ;

class Renderer
{
    private $differ;

    const FORMAT_DEFAULT    = 0;
    const FORMAT_COLOUR     = 1;

    private $predefinedFormats = [
        self::FORMAT_DEFAULT => [
            'insert' => [
                'tag' => 'ins',
            ],
            'delete' => [
                'tag' => 'del',
            ]
        ],
        self::FORMAT_COLOUR => [
            'insert' => [
                'tag' => 'ins',
                'attributes' => 'style="background: #ddfade;"',
            ],
            'delete' => [
                'tag' => 'del',
                'attributes' => 'style="background: #ffe7e7;"',
            ]
        ],
    ];

    /**
     * @var array
     */
    private $tags;

    public function __construct(array $options = [])
    {
        $this->differ = new Differ('', false);

        // set format
        if (!empty($options['format'])) {
            $this->setFormat($options['format']);
        } else {
            $this->setFormat(self::FORMAT_DEFAULT);
        }
    }

    private function normalizeFormat($format)
    {
        // format specified as numeric
        if (is_numeric($format)) {
            if (!isset($this->predefinedFormats[$format])) {
                throw new \InvalidArgumentException('Invalid format specified');
            }

            return $this->predefinedFormats[$format];
        }

        if (!is_array($format)) {
            throw new \InvalidArgumentException('Invalid format specified');
        }

        // format as array passed
        $normalizedFormat = $this->predefinedFormats[self::FORMAT_DEFAULT];
        foreach (['insert', 'delete'] as $formatType) {
            foreach (['tag', 'attributes'] as $formatParameter) {
                if (!empty($format[$formatType][$formatParameter])) {
                    $normalizedFormat[$formatType][$formatParameter] = $format[$formatType][$formatParameter];
                }
            }
        }

        return $normalizedFormat;
    }

    public function setFormat($format)
    {
        $format = $this->normalizeFormat($format);

        $this->tags['insertOpenTag'] = sprintf(
            '<%s%s>',
            $format['insert']['tag'],
            isset($format['insert']['attributes']) ? ' ' . $format['insert']['attributes'] : null
        );

        $this->tags['insertClosedTag'] = '</' . $format['insert']['tag'] . '>';

        $this->tags['deleteOpenTag'] = sprintf(
            '<%s%s>',
            $format['delete']['tag'],
            isset($format['delete']['attributes']) ? ' ' . $format['delete']['attributes'] : null
        );

        $this->tags['deleteClosedTag'] = '</' . $format['delete']['tag'] . '>';

        return $this;
    }

    /**
     * @param Change $change
     * @return string highlighted diff
     */
    public function render(Change $change)
    {
        // get diff
        $diff = $this->differ->diffToArray(
            (string)$change->getOldValue(),
            (string)$change->getNewValue()
        );

        // render diff
        foreach ($diff as &$line) {
            switch ($line[1]) {
                case 0: // NOT CHANGED
                    $line = $line[0];
                    break;
                case 1: // ADDED
                    $line = $this->tags['insertOpenTag'] . $line[0] . $this->tags['insertClosedTag'];
                    break;
                case 2: // REMOVED
                    $line = $this->tags['deleteOpenTag'] . $line[0] . $this->tags['deleteClosedTag'];
                    break;
            }
        }

        // build diff
        return implode('', $diff);
    }
}
