<?php namespace Logingrupa\OfferCollectionsShopaholic\Updates;

use Schema;
use Illuminate\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * Class CreateTableCollections
 * @package Logingrupa\OfferCollectionsShopaholic\Classes\Console
 */
class CreateTableCollectionOfferRelations extends Migration
{
    const TABLE = 'logingrupa_collection_offer';

    /**
     * Apply migration
     */
    public function up()
    {
        if (Schema::hasTable(self::TABLE)) {
            return;
        }

        Schema::create(self::TABLE, function (Blueprint $obTable) {
            $obTable->engine = 'InnoDB';
            $obTable->integer('collection_id')->unsigned();
            $obTable->integer('offer_id')->unsigned();
            $obTable->primary(['collection_id', 'offer_id']);
        });
    }

    /**
     * Rollback migration
     */
    public function down()
    {
        Schema::dropIfExists(self::TABLE);
    }
}
