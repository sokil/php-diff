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

    public function testRender_CustomFullySpecifiedFormat()
    {
        $expectedDiff = implode(PHP_EOL, [
            'line1',
            '<del style="background: #ffe7e7;">line2</del>',
            '<ins style="background: #ddfade;">line2changed</ins>',
            'line3'
        ]);

        $diffRenderer = new Renderer([
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

        $actualDiff = $diffRenderer->render(
            implode(PHP_EOL, ['line1', 'line2', 'line3']),
            implode(PHP_EOL, ['line1', 'line2changed', 'line3'])
        );

        $this->assertEquals($expectedDiff, $actualDiff);
    }

    public function testRender_CustomPartlySpecifiedFormat()
    {
        $expectedDiff = implode(PHP_EOL, [
            'line1',
            '<del>line2</del>',
            '<ins class="insert">line2changed</ins>',
            'line3'
        ]);

        $diffRenderer = new Renderer([
            'format' => [
                'insert' => [
                    'attributes' => 'class="insert"',
                ],
            ]
        ]);

        $actualDiff = $diffRenderer->render(
            implode(PHP_EOL, ['line1', 'line2', 'line3']),
            implode(PHP_EOL, ['line1', 'line2changed', 'line3'])
        );

        $this->assertEquals($expectedDiff, $actualDiff);
    }

    public function testRender_CustomNumericFormat()
    {
        $expectedDiff = implode(PHP_EOL, [
            'line1',
            '<del style="background: #ffe7e7;">line2</del>',
            '<ins style="background: #ddfade;">line2changed</ins>',
            'line3'
        ]);

        $diffRenderer = new Renderer([
            'format' => Renderer::FORMAT_COLOUR
        ]);

        $actualDiff = $diffRenderer->render(
            implode(PHP_EOL, ['line1', 'line2', 'line3']),
            implode(PHP_EOL, ['line1', 'line2changed', 'line3'])
        );

        $this->assertEquals($expectedDiff, $actualDiff);
    }
}