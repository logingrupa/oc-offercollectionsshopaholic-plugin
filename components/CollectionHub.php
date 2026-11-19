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
     * The two rows, collections first, each family carrying the nails it is
     * drawn with: three for a collection's fan, one for a colour's wall tile.
     *
     * @return array ['collections' => array, 'colors' => array]
     */
    public function get(): array
    {
        $arFamilyList = $this->obReader->familyList($this->resolveLocale(), self::COLLECTION_COVER_COUNT);

        $arSectionList = ['collections' => [], 'colors' => []];
        foreach ($arFamilyList as $arFamily) {
            $arFamily['arNailList'] = $this->applyEditorialCover($arFamily);
            $bIsCollection = $arFamily['kind'] === ColorFamilyMeta::KIND_COLLECTION;
            $arSectionList[$bIsCollection ? 'collections' : 'colors'][] = $arFamily;
        }

        return $arSectionList;
    }

    /**
     * Let an editor choose what leads a family.
     *
     * The reader hands back the most confidently-that-colour shades, which is
     * right for the grid and sometimes wrong for a cover: the white family's
     * most confident shade is a gel swirl, not a painted nail. A picture on
     * the family's collection row wins the first slot when one is set; with
     * none set nothing changes, which is the state every family ships in.
     *
     * @param array $arFamily
     * @return array<string>
     */
    protected function applyEditorialCover(array $arFamily): array
    {
        $arNailList = (array) ($arFamily['arNailList'] ?? []);

        $obEditorial = CollectionEditorial::bySlug((string) $arFamily['slug']);
        if ($obEditorial === null) {
            return $arNailList;
        }

        $obImage = $obEditorial->preview_image;
        if (empty($obImage)) {
            return $arNailList;
        }

        $sCover = OfferImageHelper::nail($obImage);
        if ($sCover === '') {
            return $arNailList;
        }

        array_unshift($arNailList, $sCover);

        return array_slice($arNailList, 0, self::COLLECTION_COVER_COUNT);
    }

    /**
     * @return string the locale the chip names are rendered in
     */
    protected function resolveLocale(): string
    {
        return (string) App::getLocale();
    }
}
