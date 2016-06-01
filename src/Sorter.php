<?php

namespace PHPLegends\SorterLaravel;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Collective\Html\HtmlBuilder;

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

    protected $fieldIndex = '_sort';

    /**
     * @var string
     * */

    protected $directionIndex = '_direction';

    /**
     * @var array
     * */
    protected $acceptedFields = [];


    protected $currentField;


    /**
     * 
     * @param \Illuminate\Routing\UrlGenerator
     * @param string $fieldIndex
     * @param string $directionIndex
     * 
     * */
    public function __construct(UrlGenerator $url, HtmlBuilder $html, $fieldIndex, $directionIndex)
    {
        $this->url = $url;

        $this->html = $html;

        $this->setFieldIndex($fieldIndex);

        $this->setDirectionIndex($directionIndex);
    }

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
     * Gets the value of direction.
     *
     * @return mixed
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * 
     * @param string $field
     * @return string
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
     * @param string $field
     * @return boolean
     * */
    public function acceptedField(array $acceptedFields)
    {
        return empty($acceptedFields) || in_array($this->currentField, $acceptedFields, true);
    }

    /**
     * Gets the value of directionIndex.
     *
     * @return mixed
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
     * @return mixed
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

}
