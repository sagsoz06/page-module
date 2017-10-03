<?php

namespace Modules\Page\Entities;

use Carbon\Carbon;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Page\Presenters\PagePresenter;
use Modules\Tag\Contracts\TaggableInterface;
use Modules\Tag\Traits\TaggableTrait;
use TypiCMS\NestableTrait;

class Page extends Model implements TaggableInterface
{
    use Translatable, TaggableTrait, NamespacedEntity, NestableTrait, PresentableTrait, MediaRelation;

    protected $table = 'page__pages';

    public $translatedAttributes = [
        'page_id',
        'title',
        'slug',
        'status',
        'body',
        'meta_title',
        'meta_description',
        'og_title',
        'og_description',
        'og_image',
        'og_type',
        'uri',
        'sub_title'
    ];

    protected $fillable = [
        'is_home',
        'template',
        'position',
        // Translatable fields
        'page_id',
        'parent_id',
        'title',
        'slug',
        'status',
        'body',
        'meta_title',
        'meta_description',
        'og_title',
        'og_description',
        'og_image',
        'og_type',
        'updated_at',
        'meta_robot_no_index',
        'meta_robot_no_follow',
        'sitemap_priority',
        'sitemap_frequency',
        'sitemap_include',
        'uri',
        'video',
        'settings'
    ];

    protected $casts = [
        'is_home' => 'boolean',
    ];

    protected $presenter = PagePresenter::class;

    protected static $entityNamespace = 'asgardcms/page';

    public function __call($method, $parameters)
    {
        #i: Convert array to dot notation
        $config = implode('.', ['asgard.page.config.relations', $method]);

        #i: Relation method resolver
        if (config()->has($config)) {
            $function = config()->get($config);
            return $function($this);
        }

        #i: No relation found, return the call to parent (Eloquent) to handle it.
        return parent::__call($method, $parameters);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Page::class, 'parent_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * Check if the current menu item is the root
     * @return bool
     */
    public function isRoot()
    {
        return (bool) $this->is_root;
    }

    public function isParent()
    {
        return (bool) !$this->parent_id;
    }

    /**
     * Check if parent_id is empty and returning null instead empty string
     * @return number
     */
    public function setParentIdAttribute($value)
    {
        $this->attributes['parent_id'] = ! empty($value) ? $value : null;
    }

    /**
     * Get the thumbnail image for the current blog post
     * @return File|string
     */
    public function getThumbnailAttribute()
    {
        if(isset($this->files()->first()->filename)) {
            return url(\Imagy::getThumbnail($this->files()->first()->filename, 'pageImage'));
        }
        return null;
    }

    public function getUrlAttribute()
    {
        return route('page', [$this->uri]);
    }

    public function hasImage()
    {
        return $this->files()->exists();
    }

    /**
     * @return string
     */
    public function getRobotsAttribute()
    {
        return $this->meta_robot_no_index.', '.$this->meta_robot_no_follow;
    }

    public function setSettingsAttribute($value)
    {
        return $this->attributes['settings'] = json_encode($value);
    }

    public function getSettingsAttribute()
    {
        $settings = json_decode($this->attributes['settings']);
        return $settings;
    }
}
