<?php

declare(strict_types=1);

namespace src\models;

use src\forms\SearchForm;

class ContextPDO
{
    public string $bookName;
    public SearchForm $searchForm;

    public function __construct(string $bookName, SearchForm $searchForm) {
        $this->bookName = $bookName;
        $this->searchForm = $searchForm;
    }
}
