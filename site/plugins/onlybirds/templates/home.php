<?php
/**
 * The one-pager. Sections render in the order the page model defines
 * (see HomePage::visibleSections()); sections without content are skipped.
 */
?>
<?php snippet('layout', slots: true) ?>

<?php snippet('sections/hero') ?>

<?php foreach ($page->visibleSections() as $key => $section): ?>
<?php snippet('sections/' . $key, ['section' => $section]) ?>
<?php endforeach ?>

<?php endsnippet() ?>
