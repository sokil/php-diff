<?php

namespace Sokil\Diff;

class RendererTest extends \PHPUnit_Framework_TestCase
{
    public function testRender()
    {
        $expectedDiff = implode(PHP_EOL, [
            'line1',
            '<del>line2</del>',
            '<ins>line2changed</ins>',
            'line3'
        ]);

        $diffRenderer = new Renderer();
        $actualDiff = $diffRenderer->render(
            implode(PHP_EOL, ['line1', 'line2', 'line3']),
            implode(PHP_EOL, ['line1', 'line2changed', 'line3'])
        );

        $this->assertEquals($expectedDiff, $actualDiff);
    }
}