<?php namespace Logingrupa\OfferCollectionsShopaholic\Classes\Collection;

use Lovata\Toolbox\Classes\Collection\ElementCollection;
use Logingrupa\OfferCollectionsShopaholic\Classes\Item\CollectionItem;
use Logingrupa\OfferCollectionsShopaholic\Classes\Store\CollectionListStore;

/**
 * Class CollectionCollection
 * @package Logingrupa\OfferCollectionsShopaholic\Classes\Collection
 */
class CollectionCollection extends ElementCollection
{
    const ITEM_CLASS = CollectionItem::class;

    /**
     * Apply filter by active field
     * @return $this
     */
    public function active()
    {
        $arResultIDList = CollectionListStore::instance()->active->get();

        return $this->intersect($arResultIDList);
    }

    /**
     * Sort list
     * @return $this
     */
    public function sort()
    {
        $arResultIDList = CollectionListStore::instance()->sorting->get();

        return $this->applySorting($arResultIDList);
    }

    /**
     * Get item by code
     * @param string $sCode
     * @return CollectionItem
     */
    public function getByCode($sCode)
    {
        if ($this->isEmpty() || empty($sCode)) {
            return CollectionItem::make(null);
        }

        $arCollectionList = $this->all();

        /** @var CollectionItem $obCollectionItem */
        foreach ($arCollectionList as $obCollectionItem) {
            if ($obCollectionItem->code == $sCode) {
                return $obCollectionItem;
            }
        }

        return CollectionItem::make(null);
    }
}
