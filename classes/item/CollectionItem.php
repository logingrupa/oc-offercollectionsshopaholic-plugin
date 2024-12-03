<?php namespace Logingrupa\OfferCollectionsShopaholic\Classes\Item;

use Cms\Classes\Page as CmsPage;

use Lovata\Toolbox\Classes\Item\ElementItem;
use Lovata\Toolbox\Classes\Helper\PageHelper;
use Lovata\Shopaholic\Classes\Collection\OfferCollection;
use Logingrupa\OfferCollectionsShopaholic\Models\Collection;

/**
 * Class CollectionItem
 * @package Logingrupa\OfferCollectionsShopaholic\Classes\Item
 *
 * @property integer $id
 * @property bool $active
 * @property string $name
 * @property string $slug
 * @property string $code
 * @property string $preview_text
 * @property string $description
 * @property int $view_count
 * @property int $sort_order
 * @property \October\Rain\Argon\Argon $created_at
 * @property \October\Rain\Argon\Argon $updated_at
 * @property \System\Models\File $preview_image
 * @property \October\Rain\Database\Collection|\System\Models\File[] $images
 */
class CollectionItem extends ElementItem
{
    const MODEL_CLASS = Collection::class;
    public $arRelationList = [
        'offer' => [
            'class' => OfferCollection::class,
            'field' => 'offer_id_list',
        ],
    ];
    /** @var Collection */
    protected $obElement = null;

    /**
     * Returns URL of a brand page.
     * @param string $sPageCode
     * @return string
     */
    public function getPageUrl($sPageCode = 'collection')
    {
        //Get URL params
        $arParamList = $this->getPageParamList($sPageCode);

        //Generate page URL
        $sURL = CmsPage::url($sPageCode, $arParamList);

        return $sURL;
    }

    /**
     * Get URL param list by page code
     * @param string $sPageCode
     * @return array
     */
    public function getPageParamList($sPageCode): array
    {
        $arPageParamList = [];

        //Get URL params for page
        $arParamList = PageHelper::instance()->getUrlParamList($sPageCode, 'CollectionPage');
        if (!empty($arParamList)) {
            $sPageParam = array_shift($arParamList);
            $arPageParamList[$sPageParam] = $this->slug;
        }

        return $arPageParamList;
    }

    /**
     * Set element data from model object
     *
     * @return array
     */
    protected function getElementData()
    {
        $arResult = [
            'offer_id_list' => $this->obElement->offer()->active()->lists('id'),
        ];

        return $arResult;
    }

}
