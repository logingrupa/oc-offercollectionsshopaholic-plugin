<?php namespace Logingrupa\OfferCollectionsShopaholic\Classes\Store\Collection;

use Lovata\Toolbox\Classes\Store\AbstractStoreWithoutParam;
use Logingrupa\OfferCollectionsShopaholic\Models\Collection;

/**
 * Class SortingListStore
 * @package Logingrupa\OfferCollectionsShopaholic\Classes\Store\Collection
 */
class SortingListStore extends AbstractStoreWithoutParam
{
    protected static $instance;

    /**
     * Get ID list from database
     * @return array
     */
    protected function getIDListFromDB(): array
    {
        $arElementIDList = (array)Collection::orderBy('sort_order', 'asc')->lists('id');

        return $arElementIDList;
    }
}
