<?php

/*
 * This file is part of the example specification package.
 *
 * (c) Rafael Calleja <rafaelcalleja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Example\Infrastructure\Persistence\Doctrine\Specification;

use Example\Domain\Specification\Specification;
use Example\Infrastructure\Persistence\Doctrine\SpecificableInterface;

trait AbstractSpecification
{
    /**
     * @param SpecificableInterface $specification
     *
     * @return SpecificableInterface
     */
    public function andSpecification(Specification $specification)
    {
        return new AndSpecification($this, $specification);
    }

    /**
     * @param SpecificableInterface $specification
     *
     * @return SpecificableInterface
     */
    public function orSpecification(Specification $specification)
    {
        return new OrSpecification($this, $specification);
    }

    /**
     * @return NotSpecification
     */
    public function not()
    {
        return new NotSpecification($this);
    }
}
