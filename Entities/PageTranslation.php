<?php

namespace Modules\Page\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Page\Events\PageContentIsRendering;

class PageTranslation extends Model
{
    protected $table = 'page__page_translations';

    protected $fillable = [
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
        'og_type'
    ];

    protected $appends = ['url'];

    public function getBodyAttribute($body)
    {
        event($event = new PageContentIsRendering($body));
        return $event->getBody();
    }

    /**
     * get the parent model.
     */
    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }

    public function getUrlAttribute()
    {
        if($this->page->is_home) {
            return localize_trans_url($this->locale, 'page::routes.homepage');
        } else {
            return localize_trans_url($this->locale, 'page::routes.page.slug', ['uri'=>$this->slug]);
        }
    }
}
