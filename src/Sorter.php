<?php

namespace PHPLegends\ColumnSorter;

use Illuminate\Routing\UrlGenerator;

class Sorter
{

    /**
     * @var UrlGenerator 
     * */
    protected $url;

    /**
     * @var string
     * */
    protected $direction;

    /**
     * @var string
     * */

    protected $index;


    public function __construct(UrlGenerator $url, $index = null)
    {
        $this->url = $url;

        $this->index = $index;
    }

    public function url($field, $path = null)
    {
        if ($path === null)
        {
            $path = $this->url->current();
        }

        $url = $path . '?' . http_build_query([$this->index => $field]);

        return $this->url->to($url);
    }

    /**
     * Gets the value of direction.
     *
     * @return mixed
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * Sets the value of direction.
     *
     * @param string $direction the direction
     *
     * @return self
     */
    public function setDirection($direction)
    {
        $this->direction = $direction;

        return $this;
    }
}