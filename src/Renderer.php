<?php

namespace Sokil\Diff;

use SebastianBergmann\Diff\Differ;

class Renderer
{
    private $differ;

    public function __construct()
    {
        $this->differ = new Differ('', false);
    }

    /**
     * @param array|string $from
     * @param array|string $to
     * @return string highlighted diff
     */
    public function render($from, $to)
    {
        $diff = $this->differ->diffToArray($from, $to);

        foreach ($diff as &$line) {
            switch ($line[1]) {
                case 0: // NOT CHANGED
                    $line = $line[0];
                    break;
                case 1: // ADDED
                    $line = '<ins>' . $line[0] . '</ins>';
                    break;
                case 2: // REMOVED
                    $line = '<del>' . $line[0] . '</del>';
                    break;
            }
        }

        return implode(PHP_EOL, $diff);
    }
}