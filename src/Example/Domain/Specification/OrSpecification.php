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

class OrSpecification implements Specification
{
    use AbstractSpecification;

    /**
     * @var Specification
     */
    protected $one;
    /**
     * @var Specification
     */
    protected $other;
    /**
     * @param Specification $one
     * @param Specification $other
     */
    public function __construct(Specification $one, Specification $other)
    {
        $this->one   = $one;
        $this->other = $other;
    }
    /**
     * @param mixed $object
     *
     * @return bool
     */
    public function isSatisfiedBy($object)
    {
        return $this->one->isSatisfiedBy($object) || $this->other->isSatisfiedBy($object);
    }
}
