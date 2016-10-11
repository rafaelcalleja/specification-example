<?php

/*
 * This file is part of the example specification package.
 *
 * (c) Rafael Calleja <rafaelcalleja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Example\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class EntityManagerFactory
{
    /**
     * @return EntityManager
     */
    public function build($conn)
    {
        if ( false === \Doctrine\DBAL\Types\Type::hasType('custom_datetime') )
        {
            \Doctrine\DBAL\Types\Type::addType('custom_datetime', 'Example\Domain\Model\DateTime\DateTimeType');
        }

        return EntityManager::create(
            $conn,
            Setup::createYAMLMetadataConfiguration(array(__DIR__.'/config'), true)
        );
    }
}
