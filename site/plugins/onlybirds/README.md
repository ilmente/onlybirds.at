# onlybirds theme

Kirby 5 theme for onlybirds.at, the one-pager of bird guide Pietro Bellezza. The whole theme is this plugin folder
(`site/plugins/onlybirds`): blueprints, templates, snippets, page model, UI translations,
CSS and JS. Deploying the theme means deploying this folder.

## What lives where

| Folder | Purpose |
| --- | --- |
| `blueprints/site.yml` | Site tab in the Panel: brand tagline, footer, default SEO, share image |
| `blueprints/pages/home.yml` | The one page: Hero · Excursions · About · Gallery · Contact · SEO tabs |
| `blueprints/pages/tour.yml` | One tour (subpage of Home): tag, kicker, dates, text, highlights, website, partner, icon, image, PDF |
| `blueprints/files/*.yml` | File types: `image` (alt text), `plate` (bird name + scientific name), `document` (PDF) |
| `blueprints/fields/*.yml` | Shared field presets used via `extends:` (single image picker, single PDF picker) |
| `templates/` | `home.php` (loops over the visible sections), `tour.php` (redirects to the excursions section), `error.php` |
| `snippets/layout.php` | `<head>`, header, `<main>` slot, footer, scripts. Templates wrap their content in it with `snippet('layout', slots: true) … endsnippet()` |
| `snippets/sections/*.php` | One snippet per section; rendered in the order `HomePage::visibleSections()` returns |
| `snippets/image.php` | The only `<img>` markup: thumbs + `srcset`, SVGs pass through |
| `snippets/svg/*.php` | Logo, hero sky, bird silhouettes |
| `models/HomePage.php` | Owns the section list that drives nav + numbering; picks the featured tour and the tour cards |
| `models/TourPage.php` | Resolves a tour's image, PDF, highlights and formatted dates |
| `translations/*.php` | Fixed UI strings per language (nav labels, button labels, aria labels) |
| `config/birds.php` | Bird silhouette paths used by the tour-card icon select |
| `assets/` | `css/site.css`, `js/site.js`; served by Kirby at `/media/plugins/herd/onlybirds/…` |

Outside the theme, deliberately small:

- `site/config/config.php` – languages on, no browser-language detection, Panel UI in English.
  `config.onlybirds.at.test.php` (local, debug on) and `config.onlybirds.at.php` (production, page cache on) override it per host.
- `site/languages/de.php`, `it.php` – German is the default language at `/`, Italian at `/it`.
- `content/` – editorial content, edited in the Panel on the server.

## Languages

One page, one content file per language (`content/home/home.de.txt`, `home.it.txt`).
Fields marked `translate: false` (images, PDF, dates, links, icons, email, phone) are shared.

To add English:

1. Create `site/languages/en.php` (copy `it.php`, set `code`, `name`, `locale`, `url: /en`).
2. Copy `translations/it.php` to `translations/en.php` and translate the values.
3. Open the Panel, switch to EN on the Home page and fill in the texts.

The language switch in the header, `hreflang` links and `<html lang>` follow automatically.

## Tours

Tours are subpages of Home (`content/home/1_<slug>/tour.<lang>.txt`), managed in the Excursions tab:
every tour has the same fields, its own image and its own PDF, uploaded once for all languages.
Only published tours appear on the site; drafts are listed separately in the Panel.

The **featured tour** fills the large card at the top of the section. It is the tour picked in
the "Featured tour" field; when nothing is picked, the published tour with the latest start date
wins, and without any dates the first tour in the list. All other published tours are shown as
cards, in the order set by dragging in the Panel. A card shows a small square thumbnail next to
the title when the tour has an image, a "PDF" link when it has a PDF, and a website link when set.

Tour pages are never rendered on their own: `/home/<slug>` redirects to the excursions section.

## Empty states

- No published tours → section 01 and its nav item disappear.
- Only one published tour → it is featured and the card row is hidden.
- No gallery plates selected → the gallery section and its nav item disappear.
- No PDF on a tour → its image is not linked and the "Open poster" button / "PDF" card link are hidden.

Section numbers (01, 02, 03) are computed from the visible sections, so they never skip.

## Deploying

Ship the code, keep the content on the server:

- Deploy: `kirby/`, `site/plugins/onlybirds/`, `site/config/`, `site/languages/`, `index.php`, `.htaccess`.
- Never overwrite: `content/`, `media/`, `site/accounts/`, `site/sessions/`, `site/cache/`, `site/config/.license`, `site/config/env.php`.
- First deployment also uploads the seed `content/` once, and creates `site/config/env.php` from `env.example.php` with fresh secrets.
- Production needs a Kirby license (installed from the Panel) and PHP 8.2+.

With git: track the code paths above, ignore `/content/*`, and let a webhook run `git pull` on the server.
On an FTP-only host, sync the `site/plugins/onlybirds/` folder (plus `kirby/` on Kirby updates).
