<?php

namespace Log1x\Pagi;

use Illuminate\Support\Arr;

class Pagi
{
    /**
     * The current WP_Query.
     *
     * @var \WP_Query
     */
    protected $query;

    /**
     * Collection of pagination items.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $items;

    /**
     * The current page.
     *
     * @var int
     */
    protected $currentPage = 1;

    /**
     * Items shown per page.
     *
     * @var int
     */
    protected $perPage = 1;

    /**
     * Create a new Pagi instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->items = collect();
    }

    /**
     * Prepare the WordPress pagination.
     *
     * @return void
     */
    protected function prepare()
    {
        $this->query = collect(
            Arr::get($GLOBALS, 'wp_query')->query_vars ?? []
        )->filter();

        if ($this->query->isEmpty()) {
            return;
        }

        $this->query->put('post_type', get_post_type());

        if (is_tax()) {
            $this->query->put('tax_query', [[
                'taxonomy' => $this->query->get('taxonomy'),
                'terms' => $this->query->get('term'),
                'field' => 'name',
            ]]);
        }

        $this->perPage = $this->query->get('posts_per_page');
        $this->currentPage = max(1, absint(get_query_var('paged')));

        $this->items = $this->items->make(
            get_posts(
                $this->query->put('posts_per_page', '-1')->all()
            )
        )->map(function ($item) {
            return [
                'id'  => $item->ID,
                'url' => get_the_permalink($item->ID)
            ];
        });
    }

    /**
     * Build the WordPress pagination.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function build()
    {
        $this->prepare();

        return new LengthAwarePaginator(
            $this->items,
            $this->items->count(),
            $this->perPage,
            $this->currentPage
        );
    }
}
