<?php namespace Logingrupa\OfferCollectionsShopaholic\Components;

use Cms\Classes\ComponentBase;
use Logingrupa\OfferCollectionsShopaholic\Classes\Collection\CollectionCollection;

/**
 * Class CollectionList
 * @package Logingrupa\OfferCollectionsShopaholic\Components
 */
class CollectionList extends ComponentBase
{
    /**
     * Component details
     * @return array
     */
    public function componentDetails()
    {
        return [
            'name' => 'logingrupa.offercollectionsshopaholic::lang.component.collection_list_name',
            'description' => 'logingrupa.offercollectionsshopaholic::lang.component.collection_list_description',
        ];
    }

    /**
     * Make element collection
     * @param array $arElementIDList
     * @return CollectionCollection
     */
    public function make($arElementIDList = null)
    {
        return CollectionCollection::make($arElementIDList);
    }

    /**
     * Method for ajax request with empty response
     * @return bool
     */
    public function onAjaxRequest()
    {
        return true;
    }
}
