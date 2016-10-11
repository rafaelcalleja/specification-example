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

class NotSpecification implements Specification
{
    use AbstractSpecification;

    /**
     * @var Specification
     */
    protected $specification;

    /**
     * @param Specification $specification
     */
    public function __construct(Specification $specification)
    {
        $this->specification = $specification;
    }

    /**
     * @param mixed $object
     *
     * @return bool
     */
    public function isSatisfiedBy($object)
    {
        return !$this->specification->isSatisfiedBy($object);
    }
}
