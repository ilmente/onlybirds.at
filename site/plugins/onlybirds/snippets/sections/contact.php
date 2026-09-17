<?php
/**
 * Contact section (unnumbered): heading, email and phone.
 * @var array $section
 */
$email = $page->contact_email();
$phone = $page->contact_phone();
?>
<section id="<?= $section['anchor'] ?>" class="contact">
  <div class="contact-inner">
    <h2><?= $page->contact_heading() ?></h2>
    <?php if ($email->isNotEmpty() || $phone->isNotEmpty()): ?>
    <div class="details">
      <?php if ($email->isNotEmpty()): ?>
      <a href="mailto:<?= $email->esc() ?>"><?= $email->esc() ?></a>
      <?php endif ?>
      <?php if ($phone->isNotEmpty()): ?>
      <a href="tel:<?= preg_replace('/[^+\d]/', '', $phone->value()) ?>"><?= $phone->esc() ?></a>
      <?php endif ?>
    </div>
    <?php endif ?>
  </div>
</section>
