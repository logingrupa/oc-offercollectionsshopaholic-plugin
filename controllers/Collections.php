<?php namespace Logingrupa\OfferCollectionsShopaholic\Controllers;

use Event;
use BackendMenu;
use Backend\Classes\Controller;
use Logingrupa\OfferCollectionsShopaholic\Classes\Event\Collection\CollectionModelHandler;

/**
 * Class Collections
 * @package Logingrupa\OfferCollectionsShopaholic\Controllers
 */
class Collections extends Controller
{
    /** @var array */
    public $implement = [
        'Backend.Behaviors.ListController',
        'Backend\Behaviors\ReorderController',
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.RelationController',
    ];
    /** @var string */
    public $listConfig = 'config_list.yaml';
    /** @var string */
    public $reorderConfig = 'config_reorder.yaml';
    /** @var string */
    public $formConfig = 'config_form.yaml';
    /** @var string */
    public $relationConfig = 'config_relation.yaml';

    /**
     * Collections constructor.
     */
    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Lovata.Shopaholic', 'shopaholic-menu-main', 'shopaholic-menu-offer-collections');
    }

    /**
     * Ajax handler onReorder event
     */
    public function onReorder()
    {
        $obResult = parent::onReorder();
        Event::fire(CollectionModelHandler::EVENT_UPDATE_SORTING);

        return $obResult;
    }
}
