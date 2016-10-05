<?php

/*
 * This file is part of the example specification package.
 *
 * (c) Rafael Calleja <rafaelcalleja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once __DIR__.'/vendor/autoload.php';

$factory = new Example\Infrastructure\Persistence\Doctrine\EntityManagerFactory();

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet(
    $factory->build(array(
        'driver' => 'pdo_sqlite',
        'path'   => __DIR__.'/db.sqlite',
    ))
);
