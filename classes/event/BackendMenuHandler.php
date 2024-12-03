<?php namespace Logingrupa\OfferCollectionsShopaholic\Classes\Event;

use Backend;

/**
 * Class BackendMenuHandler
 * @package Logingrupa\OfferCollectionsShopaholic\Classes\Event
 */
class BackendMenuHandler
{
    /**
     * Add listeners
     * @param \Illuminate\Events\Dispatcher $obEvent
     */
    public function subscribe($obEvent)
    {
        $obEvent->listen('backend.menu.extendItems', function ($obManager) {
            $this->addMenuItems($obManager);
        });
    }

    /**
     *      * Add menu items
     * @param \Backend\Classes\NavigationManager $obManager
     */
    public function addMenuItems($obManager)
    {
        $obManager->addSideMenuItems('Lovata.Shopaholic', 'shopaholic-menu-main', [
            'shopaholic-menu-offer-collections' => [
                'label' => 'logingrupa.offercollectionsshopaholic::lang.menu.collections',
                'url' => Backend::url('logingrupa/offercollectionsshopaholic/collections'),
                'icon' => 'icon-th',
                'permissions' => ['offercollectionsshopaholic-menu-collections'],
                'order' => 150,
            ],
        ]);
    }
}
