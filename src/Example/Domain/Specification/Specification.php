<?php

/*
 * This file is part of the example specification package.
 *
 * (c) Rafael Calleja <rafaelcalleja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Example\Domain\Specification;

interface Specification
{
    /**
     * @param mixed $object
     *
     * @return bool
     */
    public function isSatisfiedBy($object);

    /**
     * @param Specification $specification
     *
     * @return Specification
     */
    public function andSpecification(Specification $specification);

    /**
     * @param Specification $specification
     *
     * @return Specification
     */
    public function orSpecification(Specification $specification);

    /**
     * @return Specification
     */
    public function not();
}
