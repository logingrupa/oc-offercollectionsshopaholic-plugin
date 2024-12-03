<?php namespace Logingrupa\OfferCollectionsShopaholic\Classes\Store;

use Lovata\Toolbox\Classes\Store\AbstractListStore;
use Logingrupa\OfferCollectionsShopaholic\Classes\Store\Collection\ActiveListStore;
use Logingrupa\OfferCollectionsShopaholic\Classes\Store\Collection\SortingListStore;

/**
 * Class CollectionListStore
 * @package Logingrupa\OfferCollectionsShopaholic\Classes\Store
 * @property ActiveListStore $active
 * @property SortingListStore $sorting
 */
class CollectionListStore extends AbstractListStore
{
    protected static $instance;

    /**
     * Init store method
     */
    protected function init()
    {
        $this->addToStoreList('active', ActiveListStore::class);
        $this->addToStoreList('sorting', SortingListStore::class);
    }
}
