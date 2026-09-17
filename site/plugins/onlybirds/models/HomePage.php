<?php

use Kirby\Cms\File;
use Kirby\Cms\Files;
use Kirby\Cms\Page;
use Kirby\Cms\Pages;

/**
 * Page model for the one-pager.
 *
 * Resolves the raw fields into what the snippets need, and owns the single
 * list of visible sections that drives the navigation, the section numbers
 * and the rendering order.
 */
class HomePage extends Page
{
    /**
     * Sections in display order, limited to the ones that have content.
     * Each entry: anchor (id attribute), number ("01" … or null), label (nav text).
     */
    public function visibleSections(): array
    {
        $candidates = [
            'excursions' => ['anchor' => 'course',  'numbered' => true,  'show' => $this->tours()->isNotEmpty()],
            'about'      => ['anchor' => 'about',   'numbered' => true,  'show' => $this->about_text()->isNotEmpty()],
            'gallery'    => ['anchor' => 'gallery', 'numbered' => true,  'show' => $this->plates()->isNotEmpty()],
            'contact'    => ['anchor' => 'contact', 'numbered' => false, 'show' => true],
        ];

        $sections = [];
        $number   = 0;

        foreach ($candidates as $key => $section) {
            if ($section['show'] !== true) {
                continue;
            }

            $sections[$key] = [
                'anchor' => $section['anchor'],
                'number' => $section['numbered'] ? str_pad((string)(++$number), 2, '0', STR_PAD_LEFT) : null,
                'label'  => t('theme.nav.' . $key),
            ];
        }

        return $sections;
    }

    /**
     * Published tours in the order set in the Panel.
     */
    public function tours(): Pages
    {
        return $this->children()->listed()->filterBy('intendedTemplate', 'tour');
    }

    /**
     * The tour shown in the large card: the one picked in the Panel, otherwise the
     * published tour with the latest start date, otherwise the first one.
     */
    public function featuredTour(): TourPage|null
    {
        $picked = $this->featured_tour()->toPage();

        if ($picked instanceof TourPage && $picked->isListed() === true) {
            return $picked;
        }

        $tours = $this->tours();
        $dated = $tours->filterBy('date_from', '!=', '')->sortBy('date_from', 'desc');

        return $dated->first() ?? $tours->first();
    }

    /**
     * Published tours shown as cards: everything except the featured one.
     */
    public function tourCards(): Pages
    {
        $tours = $this->tours();

        if ($featured = $this->featuredTour()) {
            $tours = $tours->not($featured);
        }

        return $tours;
    }

    public function portrait(): File|null
    {
        return $this->about_portrait()->toFile();
    }

    public function plates(): Files
    {
        return $this->gallery_images()->toFiles();
    }
}
