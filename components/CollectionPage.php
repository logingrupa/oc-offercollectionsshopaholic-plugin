<?php namespace Logingrupa\OfferCollectionsShopaholic\Components;

use Lovata\Toolbox\Classes\Component\ElementPage;
use Logingrupa\OfferCollectionsShopaholic\Models\Collection;
use Logingrupa\OfferCollectionsShopaholic\Classes\Item\CollectionItem;

/**
 * Class CollectionPage
 * @package Logingrupa\OfferCollectionsShopaholic\Components
 */
class CollectionPage extends ElementPage
{
    /**
     * Component details
     * @return array
     */
    public function componentDetails()
    {
        return [
            'name' => 'logingrupa.offercollectionsshopaholic::lang.component.collection_page_name',
            'description' => 'logingrupa.offercollectionsshopaholic::lang.component.collection_page_description',
        ];
    }

    /**
     * Get element object
     * @param string $sElementSlug
     * @return Collection
     */
    protected function getElementObject($sElementSlug)
    {
        if (empty($sElementSlug)) {
            return null;
        }

        $obElement = Collection::active()->getBySlug($sElementSlug)->first();

        if (!empty($obElement)) {
            $obElement->view_count++;
            $obElement->save();
        }

        return $obElement;
    }

    /**
     * Make new element item
     * @param int $iElementID
     * @param Collection $obElement
     * @return CollectionItem
     */
    protected function makeItem($iElementID, $obElement)
    {
        return CollectionItem::make($iElementID, $obElement);
    }
}
