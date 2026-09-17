<?php

use Kirby\Cms\File;
use Kirby\Cms\Page;
use Kirby\Cms\Structure;

/**
 * A tour: subpage of Home. Never rendered on its own (see templates/tour.php),
 * only as the featured card or as a tour card in the excursions section.
 */
class TourPage extends Page
{
    /**
     * The one image uploaded in the "Image" section of the tour.
     */
    public function poster(): File|null
    {
        return $this->files()->template('image')->first();
    }

    /**
     * The one PDF uploaded in the "PDF" section of the tour.
     */
    public function pdf(): File|null
    {
        return $this->files()->template('document')->first();
    }

    public function highlights(): Structure
    {
        return $this->content()->get('highlights')->toStructure();
    }

    /**
     * "01.05. → 07.05.2027" – the year is only repeated when it differs; empty without a start date.
     */
    public function dates(): string
    {
        $from = $this->date_from();
        $to   = $this->date_to();

        if ($from->isEmpty() === true) {
            return '';
        }

        if ($to->isEmpty() === true) {
            return $from->toDate('d.m.Y');
        }

        $sameYear = $from->toDate('Y') === $to->toDate('Y');

        return $from->toDate($sameYear ? 'd.m.' : 'd.m.Y') . ' → ' . $to->toDate('d.m.Y');
    }

    /**
     * Domain of the website link, for the card link text ("naturschauspiel.at →").
     */
    public function linkHost(): string
    {
        $url = $this->link()->value();

        return preg_replace('/^www\./', '', parse_url($url, PHP_URL_HOST) ?? $url);
    }
}
