<?php 

declare(strict_types=1);

namespace src\helpers;

use src\models\Paragraph;

class SearchResultHelper
{
    /**
     * Returns a highlighted version of the given field from a search result's paragraph.
     * If highlighting information is available for the field, the first highlighted snippet
     * is used. Otherwise, the original text of the field is returned.
     * @param Paragraph $paragraph
     * @param string $field
     * @return string
     */
    public static function highlightFieldContent(Paragraph $paragraph, string $field): string
    {
        $highlight = $paragraph->highlight[$field] ?? [];
        $highlightedText = $highlight[0] ?? '';

        return TextProcessor::widget([
            'text' => $highlightedText ?: $paragraph->{$field},
        ]);
    }
}