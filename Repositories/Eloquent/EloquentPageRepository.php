<?php

namespace Modules\Page\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Page\Events\PageIsCreating;
use Modules\Page\Events\PageIsUpdating;
use Modules\Page\Events\PageWasCreated;
use Modules\Page\Events\PageWasDeleted;
use Modules\Page\Events\PageWasUpdated;
use Modules\Page\Repositories\PageRepository;

class EloquentPageRepository extends EloquentBaseRepository implements PageRepository
{
    /**
     * @param  mixed  $data
     * @return object
     */
    public function create($data)
    {
        if (array_get($data, 'is_home') === '1') {
            $this->removeOtherHomepage();
        }

        event($event = new PageIsCreating($data));

        $page = $this->model->create($event->getAttributes());

        event('page.updateMenuUri', [$page]);

        event(new PageWasCreated($page->id, $data, $page));

        $page->setTags(array_get($data, 'tags', []));

        return $page;
    }

    /**
     * @param $model
     * @param  array  $data
     * @return object
     */
    public function update($model, $data)
    {
        if (array_get($data, 'is_home') === '1') {
            $this->removeOtherHomepage($model->id);
        }

        event($event = new PageIsUpdating($model, $data));

        $model->update($event->getAttributes());

        event('page.updateChildrenUri', [$model]);

        event('page.updateMenuUri', [$model]);

        event(new PageWasUpdated($model->id, $data, $model));

        if(!\Request::ajax()) $model->setTags(array_get($data, 'tags', []));

        return $model;
    }

    public function destroy($page)
    {
        $page->untag();

        event(new PageWasDeleted($page));

        return $page->delete();
    }

    public function all()
    {
        if (method_exists($this->model, 'translations')) {
            return $this->model->with(['translations','parent','children'])->orderBy('position', 'ASC')->get();
        }
        return $this->model->orderBy('position', 'ASC')->with(['parent','children'])->get();
    }

    /**
     * Find the page set as homepage
     * @return object
     */
    public function findHomepage()
    {
        return $this->model->where('is_home', 1)->first();
    }

    /**
     * Count all records
     * @return int
     */
    public function countAll()
    {
        return $this->model->count();
    }

    /**
     * @param $slug
     * @param $locale
     * @return object
     */
    public function findBySlugInLocale($slug, $locale)
    {
        if (method_exists($this->model, 'translations')) {
            return $this->model->whereHas('translations', function (Builder $q) use ($slug, $locale) {
                $q->where('slug', $slug);
                $q->where('locale', $locale);
            })->with('translations')->first();
        }

        return $this->model->where('slug', $slug)->where('locale', $locale)->first();
    }

    /**
     * Set the current page set as homepage to 0
     * @param null $pageId
     */
    private function removeOtherHomepage($pageId = null)
    {
        $homepage = $this->findHomepage();
        if ($homepage === null) {
            return;
        }
        if ($pageId === $homepage->id) {
            return;
        }

        $homepage->is_home = 0;
        $homepage->save();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findByIdInLocales($id)
    {
        return $this->model->whereHas('translations', function (Builder $q) use ($id) {
            $q->where('page_id', $id);
        })->with(['translations','parent','children'])->first();
    }

    /**
     * @return array
     */
    public function pageLists()
    {
        return $this->model->with(['translations','parent','children'])->get()->pluck('title', 'id')->toArray();
    }

    /**
     * @return mixed
     */
    public function allRootsForPage()
    {
        return $this->model->with('translations')->orderBy('parent_id')->orderBy('position')->get();
    }

    /**
     * Get the root menu item for the given menu id
     *
     * @param  int    $pageId
     * @return object
     */
    public function getRootForPage($pageId)
    {
        return $this->model->with('translations')->where(['page_id' => $pageId, 'is_root' => true])->firstOrFail();
    }

    /**
     * Return a complete tree for the given menu id
     *
     * @param  int    $pageId
     * @return object
     */
    public function getTreeForPage($pageId)
    {
        $items = $this->rootsForPage($pageId);

        return $items->nest();
    }

    /**
     * Get online root elements
     *
     * @param  int    $pageId
     * @return object
     */
    public function rootsForPage($pageId)
    {
        return $this->model->whereHas('translations', function (Builder $q) {
            $q->where('locale', \App::getLocale());
        })->with('translations')->wherePageId($pageId)->orderBy('position')->get();
    }

    public function allForSelect($currentPage = '')
    {
        $pages = $this->all([], true)
            ->except($currentPage)
            ->nest()
            ->listsFlattened();
        return [''=>trans('page::pages.form.select page')] + $pages;
    }

    /**
     * @param $slug
     * @param $locale
     * @return mixed
     */
    public function findByUriInLocale($uri, $locale)
    {
        if (method_exists($this->model, 'translations')) {
            return $this->model->whereHas('translations', function (Builder $q) use ($uri, $locale) {
                $q->where('uri', $uri);
                $q->where('locale', $locale);
                $q->where('status', 1);
            })->with(['translations','parent','children'])->first();
        }

        return $this->model->where('uri', $uri)->where('locale', $locale)->with(['parent','children'])->first();
    }

    /**
     * @param $tag
     * @return mixed
     */
    public function findByTag($tag)
    {
        return $this->model->whereTag($tag)->with('tags')->get();
    }

    public function find($id)
    {
        if (method_exists($this->model, 'translations')) {
            return $this->model->with(['translations','parent','children'])->find($id);
        }

        return $this->model->find($id);
    }

    /**
     * @param $setting
     * @param $value
     * @return mixed
     */
    public function findInSettings($setting, $value)
    {
        return $this->model->whereRaw("settings REGEXP '\"{$setting}\":\"1\"'")->with(['parent', 'children', 'translations'])->get();
    }
}
