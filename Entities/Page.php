<?php

namespace Modules\Page\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
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

  /**
   * @var string
   */
  protected $table = 'page__pages';

  /**
   * @var array
   */
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
    'sub_title'
  ];

  /**
   * @var array
   */
  protected $fillable = [
    'is_home',
    'template',
    'position',
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
    'settings',
    'permissions'
  ];

  /**
   * @var array
   */
  protected $casts = [
    'is_home'     => 'boolean',
    'permissions' => 'array',
    'settings'    => 'object'
  ];

  /**
   * @var string
   */
  protected $presenter = PagePresenter::class;

  /**
   * @var string
   */
  protected static $entityNamespace = 'asgardcms/page';

  /**
   * @param string $method
   * @param array $parameters
   * @return mixed
   */
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
    return $this->hasMany(Page::class, 'parent_id', 'id')->whereHas('translations', function (Builder $q) {
      $q->where('status', 1);
    });
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function parent()
  {
    return $this->belongsTo(Page::class)->whereHas('translations', function (Builder $q) {
      $q->where('status', 1);
    });
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function recursiveParent()
  {
    return $this->parent()->with('recursiveParent');
  }

  /**
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function recursiveChildren()
  {
    return $this->children()->with('recursiveChildren');
  }

  /**
   * Check if the current menu item is the root
   * @return bool
   */
  public function isRoot()
  {
    return (bool)$this->is_root;
  }

  /**
   * @return bool
   */
  public function isParent()
  {
    return (bool)!$this->parent_id;
  }

  /**
   * Check if parent_id is empty and returning null instead empty string
   * @return number
   */
  public function setParentIdAttribute($value)
  {
    $this->attributes['parent_id'] = !empty($value) ? $value : null;
  }

  /**
   * Get the thumbnail image for the current blog post
   * @return File|string
   */
  public function getThumbnailAttribute()
  {
    if (isset($this->files()->first()->filename)) {
      return url(\Imagy::getThumbnail($this->files()->first()->filename, 'pageImage'));
    }
    return null;
  }

  /**
   * @return false|string
   */
  public function getUrlAttribute()
  {
    if ($this->is_home) {
      return localize_trans_url(locale(), 'page::routes.homepage');
    } else {
      return localize_trans_url(locale(), 'page::routes.page.slug', ['uri' => $this->slug]);
    }
  }

  /**
   * @return mixed
   */
  public function hasImage()
  {
    return $this->files()->exists();
  }

  /**
   * @return string
   */
  public function getRobotsAttribute()
  {
    return $this->meta_robot_no_index . ', ' . $this->meta_robot_no_follow;
  }

  /**
   * @return mixed|Page|null
   */
  public function getParentPageAttribute()
  {
    if (isset($this->parent->parent)) {
      $parent = $this->parent->parent;
    } elseif (isset($this->parent)) {
      $parent = $this->parent;
    } elseif (isset($this->children) && count($this->children) > 0) {
      $parent = $this;
    } else {
      $parent = null;
    }
    return $parent;
  }

  public function videos()
  {
    return $this->morphToMany(\Modules\Video\Entities\Media::class, 'relation', 'video__relations');
  }

  public function scopeMatch($query, $value)
  {
    return $query->whereHas('translations', function (Builder $q) use ($value) {
      $q->where("title", "like", "%" . $value . "%");
    })->with(['translations']);
  }

  protected function fullTextWildcards($term)
  {
    // removing symbols used by MySQL
    $term = preg_replace('/[^\p{L}\p{N}_]+/u', ' ', $term);
    $words = explode(' ', $term);
    foreach ($words as $key => $word) {
      /*
       * applying + operator (required word) only big words
       * because smaller ones are not indexed by mysql
       */
      if (strlen($word) >= 3) {
        $words[$key] = '+' . $word . '*';
      }
    }

    $searchTerm = implode(' ', $words);

    return $searchTerm;
  }
}
