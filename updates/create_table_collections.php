<?php namespace Logingrupa\OfferCollectionsShopaholic\Updates;

use Schema;
use Illuminate\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * Class CreateTableCollections
 * @package Logingrupa\OfferCollectionsShopaholic\Classes\Console
 */
class CreateTableCollections extends Migration
{
    const TABLE = 'logingrupa_offercollectionsshopaholic_collections';

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
            $obTable->increments('id')->unsigned();
            $obTable->boolean('active')->default(0);
            $obTable->string('name')->index();
            $obTable->string('slug')->unique()->index();
            $obTable->string('code')->nullable()->index();
            $obTable->text('preview_text')->nullable();
            $obTable->text('description')->nullable();
            $obTable->integer('view_count')->nullable()->default(0);
            $obTable->integer('sort_order')->nullable()->dafault(0);
            $obTable->timestamps();
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
