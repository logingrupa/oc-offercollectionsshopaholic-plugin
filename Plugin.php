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
        ];
    }
}
