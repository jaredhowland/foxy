<?php

/*
 * This file is part of the Foxy package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Foxy\Tests\Json;

use Foxy\Json\JsonFormatter;

/**
 * Tests for json formatter.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class JsonFormatterTest extends \PHPUnit_Framework_TestCase
{
    public function testGetArrayKeys()
    {
        $content = <<<JSON
{
  "name": "test",
  "contributors": [],
  "dependencies": {}
}
JSON;
        $expected = array(
            'contributors',
        );

        $this->assertSame($expected, JsonFormatter::getArrayKeys($content));
    }

    public function testGetIndent()
    {
        $content = <<<JSON
{
  "name": "test",
  "dependencies": {}
}
JSON;

        $this->assertSame(2, JsonFormatter::getIndent($content));
    }

    public function testFormat()
    {
        $expected = <<<JSON
{
  "name": "test",
  "contributors": [],
  "dependencies": {
    "@foo/bar": "^1.0.0"
  },
  "devDependencies": {}
}
JSON;
        $data = array(
            'name' => 'test',
            'contributors' => array(),
            'dependencies' => array(
                '@foo/bar' => '^1.0.0',
            ),
            'devDependencies' => array(),
        );
        $content = json_encode($data);

        $this->assertSame($expected, JsonFormatter::format($content, array('contributors'), 2));
    }
}
