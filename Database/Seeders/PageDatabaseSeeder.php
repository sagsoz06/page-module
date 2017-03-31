<?php

namespace Modules\Page\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Page\Repositories\PageRepository;

class PageDatabaseSeeder extends Seeder
{
    /**
     * @var PageRepository
     */
    private $page;

    public function __construct(PageRepository $page)
    {
        $this->page = $page;
    }

    public function run()
    {
        Model::unguard();

        $data = [
            'template' => 'home',
            'is_home' => 1,
            'en' => [
                'title' => 'Home page',
                'slug' => 'home',
                'body' => '<p><strong>Welcome to Homepage!</strong></p>',
                'meta_title' => 'Home page',
                'uri' => 'home'
            ],
            'tr' => [
                'title' => 'Anasayfa',
                'slug' => 'anasayfa',
                'body' => '<p><strong>Anasayfaya Hoşgeldiniz!</strong></p>',
                'meta_title' => 'Anasayfa',
                'uri' => 'anasayfa'
            ],
        ];
        $this->page->create($data);
    }
}
