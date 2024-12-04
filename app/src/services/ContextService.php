<?php

declare(strict_types=1);

namespace src\services;

use src\forms\QuoteForm;
use src\forms\SearchForm;
use src\models\ContextPDO;
use src\models\QuoteResultPdo;
use src\repositories\ParagraphRepository;

class ContextService
{
    private ParagraphRepository $paragraphRepository;

    public function __construct(ParagraphRepository $paragraphRepository)
    {
        $this->paragraphRepository = $paragraphRepository;
    }

    public function handle(string $id): ContextPDO
    {
        $paragraph = $this->paragraphRepository->getByParagraphID($id);
        $form = new SearchForm();
        $form->matching = 'context';
        $form->genre = $paragraph->genre;
        $form->author = $paragraph->author;
        $form->title = $paragraph->title;

        return new ContextPDO($paragraph->title, $form);
    }
}