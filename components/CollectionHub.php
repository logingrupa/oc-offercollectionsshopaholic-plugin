<?php namespace Logingrupa\OfferCollectionsShopaholic\Components;

use App;
use Cms\Classes\ComponentBase;
use Logingrupa\StoreExtender\Classes\Color\ColorFamilyHubReader;

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
     * The two chip rows, collections first.
     *
     * @return array ['collections' => array, 'colors' => array]
     */
    public function get(): array
    {
        return $this->obReader->sectionList($this->resolveLocale());
    }

    /**
     * @return string the locale the chip names are rendered in
     */
    protected function resolveLocale(): string
    {
        return (string) App::getLocale();
    }
}
