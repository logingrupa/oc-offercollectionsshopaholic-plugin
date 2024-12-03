<?php namespace Logingrupa\OfferCollectionsShopaholic\Models;

use Model;
use October\Rain\Database\Traits\Sluggable;
use October\Rain\Database\Traits\Validation;
use Kharanenka\Scope\ActiveField;
use Kharanenka\Scope\NameField;
use Kharanenka\Scope\SlugField;
use Kharanenka\Scope\CodeField;
use October\Rain\Database\Traits\Sortable;
use Lovata\Toolbox\Traits\Helpers\TraitCached;

/**
 * Class Collection
 * @package Logingrupa\OfferCollectionsShopaholic\Models
 *
 * @mixin \October\Rain\Database\Builder
 * @mixin \Eloquent
 *
 * @property integer $id
 * @property bool $active
 * @property string $name
 * @property string $slug
 * @property string $code
 * @property string $preview_text
 * @property string $description
 * @property int $view_count
 * @property int $sort_order
 * @property \October\Rain\Argon\Argon $created_at
 * @property \October\Rain\Argon\Argon $updated_at
 * @property \System\Models\File $preview_image
 * @property \October\Rain\Database\Collection|\System\Models\File[] $images
 */
class Collection extends Model
{
    use Sluggable;
    use Validation;
    use ActiveField;
    use NameField;
    use SlugField;
    use CodeField;
    use Sortable;
    use TraitCached;

    /** @var string */
    public $table = 'logingrupa_offercollectionsshopaholic_collections';
    /** @var array */
    public $implement = [
        '@RainLab.Translate.Behaviors.TranslatableModel',
    ];
    /** @var array */
    public $translatable = [
        'name',
        'preview_text',
        'description',
    ];
    /** @var array */
    public $attributeNames = [
        'name' => 'lovata.toolbox::lang.field.name',
        'slug' => 'lovata.toolbox::lang.field.slug',
    ];
    /** @var array */
    public $rules = [
        'name' => 'required',
        'slug' => 'required|unique:logingrupa_offercollectionsshopaholic_collections',
    ];
    /** @var array */
    public $slugs = [
        'slug' => 'name'
    ];
    /** @var array */
    public $jsonable = [];
    /** @var array */
    public $fillable = [
        'active',
        'name',
        'slug',
        'code',
        'preview_text',
        'description',
        'cssclass',
        'start_date',
        'end_date',
    ];
    /** @var array */
    public $cached = [
        'id',
        'active',
        'name',
        'slug',
        'code',
        'view_count',
        'preview_text',
        'description',
        'preview_image',
        'images',
        'cssclass',
        'start_date',
        'end_date',
    ];
    /** @var array */
    public $dates = [
        'created_at',
        'updated_at',
    ];
    /** @var array */
    public $casts = [];
    /** @var array */
    public $visible = [];
    /** @var array */
    public $hidden = [];
    /** @var array */
    public $hasOne = [];
    /** @var array */
    public $hasMany = [];
    /** @var array */
    public $belongsTo = [];
    /** @var array */
    public $belongsToMany = [
        'offer' => [
            'Lovata\Shopaholic\Models\Offer',
            'table' => 'logingrupa_collection_offer',
            'key' => 'collection_id',
            'otherKey' => 'offer_id',
        ],
    ];
    /** @var array */
    public $morphTo = [];
    /** @var array */
    public $morphOne = [];
    /** @var array */
    public $morphMany = [];
    /** @var array */
    public $attachOne = [
        'preview_image' => 'System\Models\File',
    ];
    /** @var array */
    public $attachMany = [
        'images' => 'System\Models\File'
    ];
    protected $purgeable = [
        'csswidht',
        'cssheight',
    ];

    // Before saving concatonete fields in cssclass field

    public function beforeSave()
    {
        // dd(post()['Collection']);
        if (empty(post()['Collection'])) {
            return;
        }
        $this->cssclass = post()['Collection']['_csswidht'] . " " . post()['Collection']['_cssheight'] . " " . post()['Collection']['_csstext'];
    }

    /**
     * Explode cssclass in to _csswidht and _cssheight for input form
     */
    public function filterFields($fields, $context = null)
    {
        if (is_null($this->cssclass)) {
            return;
        }
        $parts = explode(' ', $this->cssclass, 3);
        isset($parts[0]) ? $fields->_csswidht->value = $parts[0] : $fields->_csswidht->value = '';
        isset($parts[1]) ? $fields->_cssheight->value = $parts[1] : $fields->_cssheight->value = '';
        isset($parts[2]) ? $fields->_csstext->value = $parts[2] : $fields->_csstext->value = '';
    }
}
