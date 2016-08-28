<?php

namespace Sokil\Diff;

class RendererTest extends \PHPUnit_Framework_TestCase
{
    public function renderChangeDataProvider()
    {
        return [
            'DefaultFormat' => [
                [
                    'line1',
                    '<del>line2</del>',
                    '<ins>line2changed</ins>',
                    'line3'
                ],
                ['line1', 'line2', 'line3'],
                ['line1', 'line2changed', 'line3'],
                [],
            ],
            'CustomFullySpecifiedFormat' => [
                [
                    'line1',
                    '<del style="background: #ffe7e7;">line2</del>',
                    '<ins style="background: #ddfade;">line2changed</ins>',
                    'line3'
                ],
                ['line1', 'line2', 'line3'],
                ['line1', 'line2changed', 'line3'],
                [
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
                ]
            ],
            'CustomPartlySpecifiedFormat' => [
                [
                    'line1',
                    '<del>line2</del>',
                    '<ins class="insert">line2changed</ins>',
                    'line3'
                ],
                ['line1', 'line2', 'line3'],
                ['line1', 'line2changed', 'line3'],
                [
                    'format' => [
                        'insert' => [
                            'attributes' => 'class="insert"',
                        ],
                    ]
                ],
            ],
            'CustomNumericFormat' => [
                [
                    'line1',
                    '<del style="background: #ffe7e7;">line2</del>',
                    '<ins style="background: #ddfade;">line2changed</ins>',
                    'line3'
                ],
                ['line1', 'line2', 'line3'],
                ['line1', 'line2changed', 'line3'],
                [
                    'format' => Renderer::FORMAT_COLOUR
                ]
            ],
        ];
    }

    /**
     * @dataProvider renderChangeDataProvider
     * @param $expectedDiff
     * @param $oldValue
     * @param $newValue
     * @param array|null $renderOptions
     */
    public function testRender_ChanageValueStringType(
        $expectedDiff,
        $oldValue,
        $newValue,
        array $renderOptions = null
    ) {
        $expectedDiff = implode(PHP_EOL, $expectedDiff);

        $diffRenderer = new Renderer($renderOptions);
        $actualDiff = $diffRenderer->render(new Change(
            implode(PHP_EOL, $oldValue),
            implode(PHP_EOL, $newValue)
        ));

        $this->assertEquals($expectedDiff, $actualDiff);
    }

}