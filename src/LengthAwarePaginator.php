<?php

namespace Log1x\Pagi;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\HtmlString;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class LengthAwarePaginator extends Paginator
{
    /**
     * The default pagination view.
     *
     * @var string
     */
    public static $defaultView = 'pagi::pagination';

    /**
     * The default "simple" pagination view.
     *
     * @var string
     */
    public static $defaultSimpleView = 'pagi::pagination';

    /**
     * Get the URL for a given page number.
     *
     * @param  int  $page
     * @return string
     */
    public function url($page)
    {
        if ($page <= 0) {
            $page = 1;
        }

        $url = get_pagenum_link($page);

        if (count($this->query) > 0) {
            return $url .
                (Str::contains($url, '?') ? '&' : '?') .
                Arr::query($this->query) .
                $this->buildFragment();
        }

        return $url;
    }

    /**
     * Get the URL for the next page.
     *
     * @return string|null
     */
    public function nextPageUrl()
    {
        return next_posts(
            count($this->items),
            false
        );
    }

    /**
     * Get the URL for the previous page.
     *
     * @return string|null
     */
    public function previousPageUrl()
    {
        return previous_posts(false);
    }

    /**
     * Render the paginator using the given view.
     *
     * @param  string|null  $view
     * @param  array  $data
     * @return \Illuminate\Contracts\Support\Htmlable
     */
    public function links($view = null, $data = [])
    {
        return $this->render($view, $data);
    }

    /**
     * Render the paginator using the given view.
     *
     * @param  string|null  $view
     * @param  array  $data
     * @return \Illuminate\Contracts\Support\Htmlable
     */
    public function render($view = null, $data = [])
    {
        return new HtmlString(static::viewFactory()->make($view ?: static::$defaultView, array_merge($data, [
            'pagi' => $this,
        ]))->render());
    }

    /**
     * Get the array of elements to pass to the view.
     *
     * @return array
     */
    public function elements()
    {
        return parent::elements();
    }
}
