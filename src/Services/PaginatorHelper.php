<?php

namespace App\Services;

use Doctrine\ORM\Tools\Pagination\Paginator;

class PaginatorHelper
{

    private int $total;

    private int $lastPage;

    private $items;

    public function paginate($query, int $page = 1, int $limit = 10): static
    {
        $paginator = new Paginator($query);

        $paginator
            ->getQuery()
            ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit);

        $this->total = $paginator->count();
        $this->lastPage = (int)ceil($paginator->count() / $paginator->getQuery()->getMaxResults());
        $this->items = $paginator;

        return $this;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getLastPage(): int
    {
        return $this->lastPage;
    }

    public function getItems()
    {
        return $this->items;
    }
}
