<?php namespace Logingrupa\OfferCollectionsShopaholic\Updates;

use Schema;
use Illuminate\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * Class CreateTableCollections
 * @package Logingrupa\OfferCollectionsShopaholic\Classes\Console
 */
class UpdateTableCollectionsAddAditionalFields extends Migration
{
    const TABLE_NAME = 'logingrupa_offercollectionsshopaholic_collections';

    /**
     * Apply migration
     */
    public function up()
    {
        if (!Schema::hasTable(self::TABLE_NAME)) {
            return;
        }

        $arNewFieldList = [
            'cssclass',
            'start_date',
            'end_date',
        ];

        foreach ($arNewFieldList as $iKey => $sFieldName) {
            if (Schema::hasColumn(self::TABLE_NAME, $sFieldName)) {
                unset($arNewFieldList[$iKey]);
            }
        }

        if (empty($arNewFieldList)) {
            return;
        }

        Schema::table(self::TABLE_NAME, function (Blueprint $obTable) use ($arNewFieldList) {
            if (in_array('cssclass', $arNewFieldList)) {
                $obTable->string('cssclass')->nullable()->after('sort_order');
            }
            if (in_array('end_date', $arNewFieldList)) {
                $obTable->dateTime('end_date')->nullable()->after('slug');
            }
            if (in_array('start_date', $arNewFieldList)) {
                $obTable->dateTime('start_date')->nullable()->after('slug');
            }
        });
    }

    /**
     * Rollback migration
     */
    public function down()
    {
        if (!Schema::hasTable(self::TABLE_NAME)) {
            return;
        }

        $arNewFieldList = [
            'cssclass',
            'start_date',
            'end_date',
        ];

        foreach ($arNewFieldList as $iKey => $sFieldName) {
            if (!Schema::hasColumn(self::TABLE_NAME, $sFieldName)) {
                unset($arNewFieldList[$iKey]);
            }
        }

        if (empty($arNewFieldList)) {
            return;
        }

        Schema::table(self::TABLE_NAME, function (Blueprint $obTable) use ($arNewFieldList) {
            $obTable->dropColumn($arNewFieldList);
        });
    }
}
