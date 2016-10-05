<?php

/*
 * This file is part of the example specification package.
 *
 * (c) Rafael Calleja <rafaelcalleja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tests\Example\Functional;

use Example\Tests\TestCase;

class IntegrationTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_true()
    {
        $this->assertTrue(true);
    }
}
