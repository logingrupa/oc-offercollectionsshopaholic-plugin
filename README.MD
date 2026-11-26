# Offer Collections for Lovata Shopaholic

October CMS v4 plugin by **Logingrupa** (`logingrupa/oc-offercollectionsshopaholic-plugin`) providing editorial copy, cover art, and frontend components for the `/collections` hub and `/collections/:slug` colour-family pages.

For architecture rules and gotchas, see [CLAUDE.md](CLAUDE.md).

## Frontend Components
- **`CollectionHub`** *(primary)*: renders `/collections` rows (collections first, then colour families) using live membership from `Logingrupa.StoreExtender`'s `ColorFamilyHubReader`. Uses an uncropped editorial `sCoverImage` when present, falling back to shade nail fans (`arNailList`).
- **`CollectionFamilyPage`** *(primary)*: renders `/collections/:slug` with live shades, editorial copy via `CollectionEditorial` (read-only, no view-count write), and sibling family links.
- **`CollectionData`, `CollectionList`, `CollectionPage`** *(legacy)*: traditional Shopaholic Store -> Collection -> Item components backed by `Collection` and the dormant `logingrupa_collection_offer` pivot.

## Backend & CLI
- Backend controller `controllers/Collections.php` manages editorial `Collection` entries keyed by family slug (`cssclass`, copy, cover image).
- CLI seeder: `php artisan offercollections:seed-color-collections`.
