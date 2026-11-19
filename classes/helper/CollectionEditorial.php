<?php namespace Logingrupa\OfferCollectionsShopaholic\Classes\Helper;

use Logingrupa\OfferCollectionsShopaholic\Classes\Item\CollectionItem;
use Logingrupa\OfferCollectionsShopaholic\Models\Collection;

/**
 * Class CollectionEditorial
 *
 * The stored half of a collections-hub page: the row an editor writes.
 *
 * Membership is never read from here. The color classifier re-syncs hourly
 * and owns which shades are in a family; this row owns the words - name,
 * intro, body copy and the picture - keyed to the same family value slug.
 * A family with no row renders from the taxonomy alone, which is why every
 * read here may answer null.
 *
 * @package Logingrupa\OfferCollectionsShopaholic\Classes\Helper
 */
class CollectionEditorial
{
    /** @var array<string, CollectionItem|null> per-request memo, keyed by slug */
    protected static $arItemMemo = [];

    /**
     * The editorial row for one family value slug, or null when the family
     * has none or its row is switched off.
     *
     * @param string $sSlug family value slug
     * @return CollectionItem|null
     */
    public static function bySlug(string $sSlug): ?CollectionItem
    {
        if (array_key_exists($sSlug, static::$arItemMemo)) {
            return static::$arItemMemo[$sSlug];
        }

        static::$arItemMemo[$sSlug] = static::findBySlug($sSlug);

        return static::$arItemMemo[$sSlug];
    }

    /**
     * @param string $sSlug
     * @return CollectionItem|null
     */
    protected static function findBySlug(string $sSlug): ?CollectionItem
    {
        if ($sSlug === '') {
            return null;
        }

        $obElement = Collection::active()->getBySlug($sSlug)->first();
        if (empty($obElement)) {
            return null;
        }

        // view_count is deliberately NOT bumped here: a family page is built
        // for crawlers, and a write per page view is a write per crawl.
        $obItem = CollectionItem::make($obElement->id, $obElement);

        return $obItem->isEmpty() ? null : $obItem;
    }
}
