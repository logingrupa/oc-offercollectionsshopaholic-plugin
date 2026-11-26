# Logingrupa.OfferCollectionsShopaholic

Curated offer collections and the `/collections` editorial hub (`Logingrupa\OfferCollectionsShopaholic`, package `logingrupa/oc-offercollectionsshopaholic-plugin`). Requires `Logingrupa.StoreExtender` (one-way dependency; StoreExtender knows nothing about this plugin). Extends root `CLAUDE.md`.

## Architecture Map
- `components/CollectionHub.php`, `CollectionFamilyPage.php` - active `/collections` hub and `/collections/:slug` family pages; live shade membership comes from StoreExtender's `ColorFamilyHubReader`, never from the pivot.
- `classes/helper/CollectionEditorial.php` - read-only lookup of one `Collection` editorial row by family value slug.
- `console/SeedColorCollections.php` (`offercollections:seed-color-collections`).
- Legacy Store -> Collection -> Item stack: `models/Collection.php`, `classes/store/`, `classes/collection/`, `classes/item/`, `classes/event/` (`CollectionModelHandler`, `BackendMenuHandler`), `controllers/Collections.php`, legacy components `CollectionData`, `CollectionList`, `CollectionPage`.

## Quality Gates
No plugin test suite yet; verify theme hub/family specs from `themes/logingrupa-naisstore`.

## Gotchas
- **Editorial cover & siblings (`1.1.1`-`1.1.3`)**: `CollectionHub` attaches an uncropped `sCoverImage` (from StoreExtender `2.0.127` `OfferImageHelper::cover()`, replacing the 3-shade fan when an editorial picture exists); `arNailList` holds shade nails only; `CollectionFamilyPage` lists sibling families.
- **Dormant pivot**: `logingrupa_collection_offer` is dormant - hub membership is derived live from the colour classifier on every read so hourly color syncs stay single-source. `Collection` rows hold editorial copy and cover art keyed by family slug.
- **`cssclass` vs dates**: `cssclass` is actively used (cached on item); `start_date`/`end_date` are dormant.
- **No write-on-crawl**: legacy `CollectionPage` increments `view_count` on render; `CollectionEditorial` deliberately does not (crawler-friendly).
