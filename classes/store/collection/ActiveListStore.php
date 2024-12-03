<?php namespace Logingrupa\OfferCollectionsShopaholic\Classes\Store\Collection;

use Lovata\Toolbox\Classes\Store\AbstractStoreWithoutParam;
use Logingrupa\OfferCollectionsShopaholic\Models\Collection;

/**
 * Class ActiveListStore
 * @package Logingrupa\OfferCollectionsShopaholic\Classes\Store\Collection
 */
class ActiveListStore extends AbstractStoreWithoutParam
{
    protected static $instance;

    /**
     * Get ID list from database
     * @return array
     */
    protected function getIDListFromDB(): array
    {
        $arElementIDList = (array)Collection::active()->lists('id');

        return $arElementIDList;
    }
}
