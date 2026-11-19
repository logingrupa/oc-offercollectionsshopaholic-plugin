<?php namespace Logingrupa\OfferCollectionsShopaholic;

use Event;
use System\Classes\PluginBase;

use Logingrupa\OfferCollectionsShopaholic\Classes\Event\Collection\CollectionModelHandler;
use Logingrupa\OfferCollectionsShopaholic\Classes\Event\BackendMenuHandler;

/**
 * Class Plugin
 * @package Logingrupa\OfferCollectionsShopaholic
 */
class Plugin extends PluginBase
{
    /**
     * StoreExtender owns the colour taxonomy the collections hub derives its
     * membership from, so it must boot first.
     *
     * @var array
     */
    public $require = [
        'Logingrupa.StoreExtender',
    ];

    /**
     * Plugin boot method
     */
    public function boot()
    {
        $this->addEventListener();
    }

    /**
     * Add event listeners
     */
    protected function addEventListener()
    {
        Event::subscribe(BackendMenuHandler::class);
        Event::subscribe(CollectionModelHandler::class);
    }

    /**
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Logingrupa\OfferCollectionsShopaholic\Components\CollectionList' => 'CollectionList',
            'Logingrupa\OfferCollectionsShopaholic\Components\CollectionPage' => 'CollectionPage',
            'Logingrupa\OfferCollectionsShopaholic\Components\CollectionData' => 'CollectionData',
            'Logingrupa\OfferCollectionsShopaholic\Components\CollectionHub' => 'CollectionHub',
            'Logingrupa\OfferCollectionsShopaholic\Components\CollectionFamilyPage' => 'CollectionFamilyPage',
        ];
    }

    /**
     * Register console commands
     */
    public function register()
    {
        $this->registerConsoleCommand(
            'offercollections.seed_color_collections',
            \Logingrupa\OfferCollectionsShopaholic\Console\SeedColorCollections::class
        );
    }
}
