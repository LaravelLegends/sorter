<?php

namespace LaravelLegends\Sorter;

use Illuminate\Http\Request;
use Collective\Html\HtmlBuilder;
use Illuminate\Routing\UrlGenerator;

class Sorter
{

    /**
     * @var UrlGenerator 
     * */
    protected $url;

    /**
     * 
     * @var HtmlBuilder
     * */

    protected $html;

    /**
     * 
     * @var Request
     * */

    protected $request;

    /**
     * @var string
     * */
    protected $direction;

    /**
     * @var string
     * */

    protected $fieldIndex;

    /**
     * @var string
     * */

    protected $directionIndex;

    /**
     * @var array
     * */
    protected $acceptedFields = [];

    /**
     * @var string
     * */
    protected $currentField;


    /**
     * Constructs the Sorter
     * 
     * @param \Illuminate\Routing\UrlGenerator
     * @param \Collective\Html\HtmlBuilder
     * @param Illuminate\Http\Request
     * @param string $fieldIndex
     * @param string $directionIndex
     * 
     * */
    public function __construct(
        UrlGenerator $url,
        HtmlBuilder $html,
        Request $request,
        $fieldIndex = '_sort',
        $directionIndex = '_order'
    ) {

        $this->url = $url;

        $this->html = $html;

        $this->request = $request;

        $this->setFieldIndex($fieldIndex);

        $this->setDirectionIndex($directionIndex);

        $this->setCurrentField(
            $request->get($fieldIndex)
        );

        $this->setDirection(
            $request->get($directionIndex)
        );
    }

    /**
     * Generates a url for Sorter
     * 
     * @param string $field
     * @param null|string $path
     * */
    public function url($field, $path = null)
    {
        if ($path === null)
        {
            $path = $this->url->current();
        }

        $queryString = [
            $this->getFieldIndex()     => $field,
            $this->getDirectionIndex() => $this->getConditionallyDirection($field)
        ];

        $url = $path . '?' . http_build_query($queryString);

        return $this->url->to($url);
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
     * Returns'asc' or 'desc' according with passed field
     * 
     * @param string $field
     * @return string ('asc' or 'desc')
     * */

    public function getConditionallyDirection($field)
    {
        if ($this->getDirection() === 'asc' && $this->getCurrentField() == $field)
        {
            return 'desc';
        }

        return 'asc';
    }
   

    /**
     * Sets the value of currentField.
     *
     * @param mixed $currentField the current field
     *
     * @return self
     */
    public function setCurrentField($currentField)
    {
        $this->currentField = $currentField;

        return $this;
    }

    /**
     * Returns the current sorting field
     * 
     * @param Request $request
     * @return null|string
     * */
    public function getCurrentField()
    {
       return $this->currentField;

    }

    /**
     * 
     * Check if current field exists in whitelist. If whitelist is empty, is ok
     * 
     * @param string $field
     * @return boolean
     * */
    public function checkCurrentByWhitelist(array $acceptedFields)
    {
        return empty($acceptedFields) || in_array($this->currentField, $acceptedFields, true);
    }

    /**
     * Gets the value of directionIndex.
     *
     * @return string
     */
    public function getDirectionIndex()
    {
        return $this->directionIndex;
    }

    /**
     * Sets the value of directionIndex.
     *
     * @param string $directionIndex the direction index
     *
     * @return self
     */
    public function setDirectionIndex($directionIndex)
    {
        $this->directionIndex = $directionIndex;

        return $this;
    }

    /**
     * Gets the value of FieldIndex.
     *
     * @return string
     */
    public function getFieldIndex()
    {
        return $this->fieldIndex;
    }

    /**
     * Sets the value of FieldIndex.
     *
     * @param mixed $FieldIndex the field index
     *
     * @return self
     */
    public function setFieldIndex($fieldIndex)
    {
        $this->fieldIndex = $fieldIndex;

        return $this;
    }

    /**
     * Generates a link for sor url
     * 
     * @param string $field
     * @param string|null $name
     * @param array $attributes
     * @param string|null $path
     * 
    */
    public function link($field, $name = null, array $attributes = [], $path = null)
    {
        if ($name === null) {

            $name = ucwords(strtr($field, ['_' => ' ', '-' => ' ']));
        }

        $attributes += [
            'data-laravel-sorter-direction' => $this->getConditionallyDirection($field)
        ];

        return $this->html->link($this->url($field, $path), $name, $attributes);
    }

    /**
     * Checks if "sorter" order is currently active
     * 
     * @return boolean
     * */
    public function isActive()
    {
        return $this->request->has($this->getFieldIndex(), $this->getDirectionIndex());
    }
}
