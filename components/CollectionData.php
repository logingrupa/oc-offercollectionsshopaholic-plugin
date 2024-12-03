<?php namespace Logingrupa\OfferCollectionsShopaholic\Components;

use Lovata\Toolbox\Classes\Component\ElementData;
use Logingrupa\OfferCollectionsShopaholic\Classes\Item\CollectionItem;

/**
 * Class CollectionData
 * @package Logingrupa\OfferCollectionsShopaholic\Components
 */
class CollectionData extends ElementData
{
    /**
     * Component details
     * @return array
     */
    public function componentDetails()
    {
        return [
            'name' => 'logingrupa.offercollectionsshopaholic::lang.component.collection_data_name',
            'description' => 'logingrupa.offercollectionsshopaholic::lang.component.collection_data_description',
        ];
    }

    /**
     * Make new element item
     * @param int $iElementID
     * @return CollectionItem
     */
    protected function makeItem($iElementID)
    {
        return CollectionItem::make($iElementID);
    }
}
