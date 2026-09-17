<?php
/**
 * Tours are never pages of their own: a direct request is sent to the
 * excursions section of the home page (in the same language).
 */
$home   = $page->parent();
$anchor = $home->visibleSections()['excursions']['anchor'] ?? null;

go($home->url() . ($anchor ? '#' . $anchor : ''), 302);
