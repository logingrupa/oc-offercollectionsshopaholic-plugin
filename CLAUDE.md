# Logingrupa.OfferCollectionsShopaholic

Curated offer collections: a Collection model with an offers pivot, full cached
Store -> Collection -> Item stack, three frontend components and a backend controller.
Namespace Logingrupa\OfferCollectionsShopaholic, composer package
logingrupa/oc-offercollectionsshopaholic-plugin. README.MD documents usage.

## Environment

- Parent app: C:\laragon\www\nc.
- This plugin dir is its OWN git repo - commit here, not in the root repo.

## Architecture map

- models/              Collection (+ models/collection yaml configs)
- classes/helper/      CollectionEditorial (one Collection row by family value slug, read only)
- components/          CollectionHub, CollectionFamilyPage - the /collections hub and
                       /collections/:slug family page; membership comes from
                       Logingrupa.StoreExtender's ColorFamilyHubReader, never from the pivot
- console/             offercollections:seed-color-collections
- classes/store/       CollectionListStore, collection/ActiveListStore, collection/SortingListStore
- classes/collection/  CollectionCollection
- classes/item/        CollectionItem
- classes/event/       collection/CollectionModelHandler (cache invalidation),
                       BackendMenuHandler (backend menu injection)
- components/          CollectionData, CollectionList, CollectionPage
- controllers/         Collections backend controller (+ controllers/collections views)
- updates/             create table collections, pivot collection_offer,
                       add cssclass + start_date/end_date fields
- plugin.yaml          name, offercollectionsshopaholic-menu-collections permission

## Quality gates

No working automated gate - tests do not exist and lint does not cover this dir.
composer lint does NOT cover this plugin (phpcs.xml scope excludes plugins/logingrupa) - fix
phpcs.xml scope or lint manually; `vendor/bin/phpcs --standard=phpcs.xml <plugin path>` won't
work either since the ruleset pins files; note as known gap.

## Ship

Ship via /nc-ship (root CLAUDE.md release flow); package logingrupa/oc-offercollectionsshopaholic-plugin.

## Conventions

Root CLAUDE.md governs: Hungarian notation, Store -> Collection -> Item read path, Tiger-Style.

## Gotchas

- cssclass is actively used (beforeSave/afterFetch in Collection.php, cached on item);
  start_date/end_date are dormant.
- The `logingrupa_collection_offer` pivot is dormant too. The collections hub derives
  membership from the colour classifier on every read, because that classifier re-syncs
  hourly and a copied pivot gives two answers to "what is in DISCO" within a day. A
  Collection row holds editorial copy only, keyed to the family value slug.
- CollectionPage bumps view_count and saves on every render. CollectionEditorial
  deliberately does not: a family page is built for crawlers, and a write per page view
  is a write per crawl.
- The plugin now requires Logingrupa.StoreExtender (the colour taxonomy owner). The
  dependency runs one way only; StoreExtender knows nothing about this plugin.
