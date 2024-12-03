<?php namespace Logingrupa\OfferCollectionsShopaholic\Classes\Event\Collection;

use Lovata\Toolbox\Classes\Event\ModelHandler;
use Logingrupa\OfferCollectionsShopaholic\Models\Collection;
use Logingrupa\OfferCollectionsShopaholic\Classes\Item\CollectionItem;
use Logingrupa\OfferCollectionsShopaholic\Classes\Store\CollectionListStore;

/**
 * Class CollectionModelHandler
 * @package Logingrupa\OfferCollectionsShopaholic\Classes\Event\Collection
 */
class CollectionModelHandler extends ModelHandler
{
    const EVENT_UPDATE_SORTING = 'offercollectionsshopaholic.collection.update.sorting';

    /** @var Collection */
    protected $obElement;

    /**
     * Add listeners
     * @param \Illuminate\Events\Dispatcher $obEvent
     */
    public function subscribe($obEvent)
    {
        parent::subscribe($obEvent);

        $obEvent->listen(self::EVENT_UPDATE_SORTING, function () {
            CollectionListStore::instance()->sorting->clear();
        });
    }

    /**
     * Get model class name
     * @return string
     */
    protected function getModelClass()
    {
        return Collection::class;
    }

    /**
     * Get item class name
     * @return string
     */
    protected function getItemClass()
    {
        return CollectionItem::class;
    }

    /**
     * After create event handler
     */
    protected function afterCreate()
    {
        parent::afterCreate();
    }

    /**
     * After save event handler
     */
    protected function afterSave()
    {
        parent::afterSave();

        $this->checkFieldChanges('active', CollectionListStore::instance()->active);
    }

    /**
     * After delete event handler
     */
    protected function afterDelete()
    {
        parent::afterDelete();

        if ($this->obElement->active) {
            CollectionListStore::instance()->active->clear();
        }

        CollectionListStore::instance()->sorting->clear();
    }
}
