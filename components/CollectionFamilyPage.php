<?php namespace Logingrupa\OfferCollectionsShopaholic\Components;

use App;
use Cms\Classes\ComponentBase;
use Logingrupa\OfferCollectionsShopaholic\Classes\Helper\CollectionEditorial;
use Logingrupa\StoreExtender\Classes\Color\ColorFamilyHubReader;
use Lovata\Toolbox\Traits\Helpers\TraitComponentNotFoundResponse;

/**
 * Class CollectionFamilyPage
 * @package Logingrupa\OfferCollectionsShopaholic\Components
 *
 * One page per colour family and per collection, at /collections/<value_slug>.
 * It answers the question the catalogue filter cannot: the catalogue filters
 * in products, while the shop carries a hundred red shades across every
 * product type. This page shows the shades.
 *
 * Three answers, in this order:
 *  - unknown slug, or a family with no live shade: 404 (Gold and Beige carry
 *    none, so they have no page at all)
 *  - fewer shades than the threshold: 200 with noindex,follow - the page
 *    exists and is linked, it just is not worth an index entry
 *  - at or above the threshold: 200, indexable, listed in the sitemap
 */
class CollectionFamilyPage extends ComponentBase
{
    use TraitComponentNotFoundResponse;

    /** Needed by the trait's property builder; this page has no smart URL check */
    protected $bNeedSmartURLCheck = false;

    /** @var ColorFamilyHubReader */
    protected $obReader;

    /** @var array|null the resolved family, null when the slug has no page */
    protected $arFamily = null;

    public function componentDetails()
    {
        return [
            'name'        => 'logingrupa.offercollectionsshopaholic::lang.component.collection_family_page_name',
            'description' => 'logingrupa.offercollectionsshopaholic::lang.component.collection_family_page_description',
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title'   => 'lovata.toolbox::lang.component.property_slug',
                'type'    => 'string',
                'default' => '{{ :slug }}',
            ],
        ];
    }

    public function init()
    {
        $this->obReader = new ColorFamilyHubReader();

        $sSlug = $this->getSlug();
        if ($sSlug === '') {
            return;
        }

        $this->arFamily = $this->obReader->family($sSlug, (string) App::getLocale());
    }

    /**
     * @return \Illuminate\Http\Response|null the 404 when this slug has no page
     * @throws \October\Rain\Exception\AjaxException
     */
    public function onRun()
    {
        if ($this->arFamily === null) {
            return $this->getErrorResponse();
        }

        return null;
    }

    /**
     * The family, or null on the 404 path.
     *
     * @return array|null ['slug','name','family','kind','hex','background','count','path','bIsIndexable']
     */
    public function get(): ?array
    {
        return $this->arFamily;
    }

    /**
     * The shade ids this page draws, confidence ordered. Empty on the 404
     * path, so a template that renders before onRun cannot fatal.
     *
     * @return array
     */
    public function getOfferIdList(): array
    {
        if ($this->arFamily === null) {
            return [];
        }

        return $this->obReader->offerIdList($this->arFamily['slug']);
    }

    /**
     * The stored copy for this family, or null when no editor has written
     * one yet. The page renders from the taxonomy without it.
     *
     * @return \Logingrupa\OfferCollectionsShopaholic\Classes\Item\CollectionItem|null
     */
    public function getEditorial()
    {
        if ($this->arFamily === null) {
            return null;
        }

        return CollectionEditorial::bySlug($this->arFamily['slug']);
    }

    /**
     * Whether this page asks to be indexed. False is a thin page, not a
     * broken one - it still renders and still links onward.
     *
     * @return bool
     */
    public function isIndexable(): bool
    {
        return $this->arFamily !== null && $this->arFamily['bIsIndexable'];
    }

    /**
     * Whether this family is a named collection rather than a colour.
     *
     * @return bool
     */
    public function isCollection(): bool
    {
        return $this->arFamily !== null
            && $this->arFamily['kind'] === \Logingrupa\StoreExtender\Models\ColorFamilyMeta::KIND_COLLECTION;
    }

    /**
     * @return string the requested family value slug
     */
    protected function getSlug(): string
    {
        return trim((string) $this->property('slug'));
    }
}
