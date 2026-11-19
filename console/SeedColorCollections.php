<?php namespace Logingrupa\OfferCollectionsShopaholic\Console;

use Illuminate\Console\Command;
use Logingrupa\OfferCollectionsShopaholic\Models\Collection;
use Logingrupa\StoreExtender\Classes\Color\ColorFamilyHubReader;
use Logingrupa\StoreExtender\Classes\Color\ColorFamilyMatcher;

/**
 * Class SeedColorCollections
 *
 * Give every family the hub lists a row an editor can write in.
 *
 * The row holds words only - name, intro, body copy, picture. Membership is
 * never written here; it is derived from the colour taxonomy on every read,
 * because the classifier re-syncs hourly and a copied membership pivot gives
 * two answers to "what is in DISCO" within a day.
 *
 * Idempotent by design and deliberately blunt about it: an existing row is
 * NEVER touched, in any field. An editor who rewrote a name, or emptied one
 * on purpose, must be able to run this command again without losing it. The
 * only thing a second run does is create rows for families that appeared
 * since the first.
 *
 * @package Logingrupa\OfferCollectionsShopaholic\Console
 */
class SeedColorCollections extends Command
{
    /** @var string */
    protected $signature = 'offercollections:seed-color-collections
        {--dry-run : List what would be created and write nothing}
        {--inactive : Create the rows switched off, for an editor to publish by hand}';

    /** @var string */
    protected $description = 'Create an editorial row for every colour family and collection that has none';

    public function handle(): int
    {
        $arFamilyList = (new ColorFamilyHubReader())->familyList(ColorFamilyMatcher::LOCALE_DEFAULT);
        if (empty($arFamilyList)) {
            $this->error('No colour family carries a live shade - run storeextender:sync-offer-colors first.');

            return self::FAILURE;
        }

        $bDryRun = (bool) $this->option('dry-run');
        $bActive = !$this->option('inactive');

        $iCreated = 0;
        $iKept = 0;
        foreach ($arFamilyList as $arFamily) {
            $sSlug = (string) $arFamily['slug'];
            if (Collection::where('slug', $sSlug)->exists()) {
                $iKept++;
                continue;
            }

            $this->line(($bDryRun ? 'would create  ' : 'created  ').$sSlug.'  ('.$arFamily['name'].', '.$arFamily['count'].' shades)');
            if ($bDryRun) {
                $iCreated++;
                continue;
            }

            $this->createRow($sSlug, (string) $arFamily['name'], $bActive);
            $iCreated++;
        }

        $this->info(sprintf(
            '%s %d row(s), left %d existing row(s) untouched.',
            $bDryRun ? 'Would create' : 'Created',
            $iCreated,
            $iKept
        ));

        return self::SUCCESS;
    }

    /**
     * One editorial row. Only the two fields that cannot be derived are
     * filled: the slug, which keys the row to the family, and the name,
     * which is the family's own display name until an editor improves it.
     *
     * @param string $sSlug
     * @param string $sName
     * @param bool   $bActive
     * @return void
     */
    protected function createRow(string $sSlug, string $sName, bool $bActive): void
    {
        $obCollection = new Collection();
        $obCollection->name = $sName !== '' ? $sName : $sSlug;
        $obCollection->slug = $sSlug;
        $obCollection->active = $bActive;
        $obCollection->save();
    }
}
