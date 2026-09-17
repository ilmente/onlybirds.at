# onlybirds theme

Kirby 5 theme for onlybirds.at, the one-pager of bird guide Pietro Bellezza. The whole theme is this plugin folder
(`site/plugins/onlybirds`): blueprints, templates, snippets, page model, UI translations,
CSS and JS. Deploying the theme means deploying this folder.

## What lives where

| Folder | Purpose |
| --- | --- |
| `blueprints/site.yml` | Site page in the Panel: the Home page card, brand tagline, footer, meta description and share image |
| `blueprints/pages/home.yml` | The one page: Hero · Excursions · About · Gallery · Contact · SEO tabs |
| `blueprints/pages/tour.yml` | One tour (subpage of Home): tag, kicker, dates, text, highlights, website, partner, icon, image, PDF |
| `blueprints/files/*.yml` | File types: `image` (alt text), `plate` (bird name + scientific name), `document` (PDF) |
| `templates/` | `home.php` (loops over the visible sections), `tour.php` (redirects to the excursions section), `error.php` |
| `snippets/layout.php` | `<head>`, header, `<main>` slot, footer, scripts. Templates wrap their content in it with `snippet('layout', slots: true) … endsnippet()` |
| `snippets/sections/*.php` | One snippet per section; rendered in the order `HomePage::visibleSections()` returns |
| `snippets/image.php` | The only `<img>` markup: thumbs + `srcset`, SVGs pass through |
| `snippets/svg/*.php` | Brand mark (from the logo kit), hero sky, bird silhouettes |
| `models/HomePage.php` | Owns the section list that drives nav + numbering; picks the featured tour and the tour cards |
| `models/TourPage.php` | Resolves a tour's image, PDF, highlights and formatted dates |
| `translations/*.php` | Fixed UI strings per language (nav labels, button labels, aria labels) |
| `config/birds.php` | Bird silhouette paths used by the tour-card icon select |
| `config/routes.php` | Root URLs for the icon files (`/favicon.ico`, `/apple-touch-icon.png`, …) and the web app manifest |
| `assets/` | `css/site.css`, `js/site.js`, `icons/` (favicon, home screen icons, share image); served by Kirby at `/media/plugins/ilmente/onlybirds/…` |

Outside the theme, deliberately small:

- `site/config/config.php` – languages on, no browser-language detection, Panel UI in English.
  Host-specific settings (debug, cache, secrets) live in `config.<host>.php` files that are not tracked.
- `site/languages/de.php`, `it.php` – German is the default language at `/`, Italian at `/it`.
- `content/` – editorial content, edited in the Panel on the server.

## Languages

One page, one content file per language (`content/home/home.de.txt`, `home.it.txt`).
Fields marked `translate: false` (dates, links, icons, email, phone, featured tour) are shared and
can only be edited while the Panel shows the default language.

Images and PDFs are not fields but files sections, so they can be added in any language:
the portrait is the one `image` file on Home, the plates are the `plate` files on Home (max 8,
drag to sort), a tour's poster and PDF are its one `image` and one `document` file. The share
image is a files field on the Site page (upload or pick a site image; one for all languages).
Each file is uploaded once; only its metadata (alt text, bird name) is per language.

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

## Brand and icons

The header shows the brand mark (`snippets/svg/logo.php`, the "sunrise glider" from the logo kit)
next to the site title and tagline as live text, so the name can change in the Panel without
touching the logo.

`assets/icons/` holds the favicon (`favicon.ico` with 16/32/48 px and `favicon.svg`), the iOS home
screen icon (`apple-touch-icon.png`, 180 px), the Android icons (`icon-192.png`, `icon-512.png`, plus
full-bleed `-maskable` variants for adaptive icon shapes) and the default share image
(`share-image.png`, 1200×630). The theme serves the icons at the site root (`/favicon.ico`,
`/apple-touch-icon.png`, …) and a web app manifest per language (`/site.webmanifest`,
`/it/site.webmanifest`) via `config/routes.php`, so "Add to Home Screen" on iOS and Android gets
the right icon and name. The share image is the Open Graph fallback: an image picked in the
"Share image" field on the Site page in the Panel takes precedence and is cropped to 1200×630
(the crop follows the image's focus point). The Panel uses the same icons (`panel.favicon` in
`site/config/config.php`).

## Deploying

Ship the code, keep the content on the server:

- Deploy: `kirby/`, `site/plugins/onlybirds/`, `site/config/`, `site/languages/`, `index.php`, `.htaccess`.
- Never overwrite: `content/`, `media/`, `site/accounts/`, `site/sessions/`, `site/cache/`, `site/config/.license`.
- First deployment also uploads the seed `content/` once.
- Production needs a Kirby license (installed from the Panel) and PHP 8.2+.
- Kirby's pages cache (if enabled in the host config) is flushed automatically by the theme
  whenever a deployment changes a theme file; content changes flush it via Kirby itself.

With git: track the code paths above, ignore `/content/*`, and let a webhook run `git pull` on the server.
On an FTP-only host, sync the `site/plugins/onlybirds/` folder (plus `kirby/` on Kirby updates).
