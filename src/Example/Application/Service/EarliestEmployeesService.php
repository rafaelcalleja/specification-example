<?php

namespace Example\Application\Service;

use Example\Domain\Model\Employee\EmployeeRepository;
use Example\Infrastructure\Persistence\Sql\Employee\SqlFromEmployeeSpecification;

class EarliestEmployeesService
{

    /**
     * @var EmployeeRepository
     */
    private $repository;

    public function __construct(EmployeeRepository $repository)
    {

        $this->repository = $repository;
    }

    public function execute($request)
    {
        // ...

        $employees = $this->repository->query(
            new SqlFromEmployeeSpecification(
                new \DateTimeImmutable('-1 year')
            )
        );

        /**
         *  Comentario:
         *  Usar una implementacion concreta es una mala idea,
         *  Estamos acoplando un high-level application service EarliestEmployeesService
         *  con una implementacion de una Specificacion low-level
         *  mezclando y saltandose el principio de separación de capas / Separation of Concerns
         *
         *  Por ejemplo, Este servicio no tiene forma de ejecutarse sin usar SQL como persistencia
         *  ¿ Como testeamos el servicio usando la implementacion de in-memory ?
         *
        **/

        // ...
    }
}