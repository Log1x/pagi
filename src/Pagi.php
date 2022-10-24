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
     * Prepare the WordPress pagination.
     *
     * @return void
     */
    protected function prepare()
    {
        if (! isset($this->query)) {
            $this->query = collect(
                Arr::get($GLOBALS, 'wp_query')->query_vars ?? []
            )->filter();

            $this->items = collect()->range(0, Arr::get($GLOBALS, 'wp_query')->found_posts);
        }

        if ($this->query->isEmpty()) {
            return;
        }

        $this->perPage = $this->query->get('posts_per_page');
        $this->currentPage = max(1, absint(get_query_var('paged')));
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

    /**
     * Set the WordPress query.
     *
     * @param  \WP_Query
     * @return void
     */
    public function setQuery($query)
    {
        $this->items = collect()->range(0, $query->found_posts);
        $this->query = collect(
            $query->query_vars ?? []
        )->filter();
    }
}
