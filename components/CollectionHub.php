<?php namespace Logingrupa\OfferCollectionsShopaholic\Components;

use App;
use Cms\Classes\ComponentBase;
use Logingrupa\OfferCollectionsShopaholic\Classes\Helper\CollectionEditorial;
use Logingrupa\StoreExtender\Classes\Color\ColorFamilyHubReader;
use Logingrupa\StoreExtender\Classes\Helper\OfferImageHelper;
use Logingrupa\StoreExtender\Models\ColorFamilyMeta;

/**
 * Class CollectionHub
 * @package Logingrupa\OfferCollectionsShopaholic\Components
 *
 * The /collections index: every collection this shop carries, then every
 * colour family, each one a chip into its own page.
 *
 * The chips are derived live from the colour taxonomy (StoreExtender owns
 * that read), so a collection the classifier adds appears here on its next
 * sync with no editing. A family carrying no live shade is left out: a chip
 * is a promise of results.
 */
class CollectionHub extends ComponentBase
{
    /** Nails a collection fans out */
    const COLLECTION_COVER_COUNT = 3;

    /** @var ColorFamilyHubReader */
    protected $obReader;

    public function componentDetails()
    {
        return [
            'name'        => 'logingrupa.offercollectionsshopaholic::lang.component.collection_hub_name',
            'description' => 'logingrupa.offercollectionsshopaholic::lang.component.collection_hub_description',
        ];
    }

    public function init()
    {
        $this->obReader = new ColorFamilyHubReader();
    }

    /**
     * The two rows, collections first, each family carrying what it is drawn
     * with: an editor's own cover when the family has one, otherwise the
     * shades - three for a collection's fan, one for a colour's wall tile.
     *
     * @return array ['collections' => array, 'colors' => array]
     */
    public function get(): array
    {
        $arFamilyList = $this->obReader->familyList($this->resolveLocale(), self::COLLECTION_COVER_COUNT);

        $arSectionList = ['collections' => [], 'colors' => []];
        foreach ($arFamilyList as $arFamily) {
            $arFamily['sCoverImage'] = $this->resolveEditorialCover($arFamily);
            $bIsCollection = $arFamily['kind'] === ColorFamilyMeta::KIND_COLLECTION;
            $arSectionList[$bIsCollection ? 'collections' : 'colors'][] = $arFamily;
        }

        return $arSectionList;
    }

    /**
     * Let an editor choose what leads a family.
     *
     * The reader hands back the most confidently-that-colour shades, which is
     * right for a fan of nails and wrong for a collection: a collection is
     * sold as a designed set, and its poster says more than three of its
     * shades do. A picture on the family's collection row replaces the fan
     * when one is set, fitted whole and never cropped - the nail ratio is a
     * shade's ratio and a poster does not share it.
     *
     * With no picture set nothing changes, which is the state every family
     * ships in: the tile draws its shades exactly as before.
     *
     * @param array $arFamily
     * @return string the cover URL, or an empty string to draw the shades
     */
    protected function resolveEditorialCover(array $arFamily): string
    {
        $obEditorial = CollectionEditorial::bySlug((string) $arFamily['slug']);
        if ($obEditorial === null) {
            return '';
        }

        $obImage = $obEditorial->preview_image;
        if (empty($obImage)) {
            return '';
        }

        return OfferImageHelper::cover($obImage);
    }

    /**
     * @return string the locale the chip names are rendered in
     */
    protected function resolveLocale(): string
    {
        return (string) App::getLocale();
    }
}
