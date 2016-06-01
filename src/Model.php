<?php

namespace LaravelLegends\Sorter;

use LaravelLegends\Sorter\Facade as SorterFacade;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{

    /**
     * 
     * 
     * 
     * @param Illuminate\Database\Query\Builder $query
     * @param array $acceptedFields
     * @return  Illuminate\Database\Query\Builder
     * */
    public function scopeOrderBySorter($query, array $acceptedFields = [])
    {
        $field = SorterFacade::getCurrentfield();

        if ($field && SorterFacade::acceptedField($acceptedFields))
        {
            $query->orderBy($field, SorterFacade::getDirection());
        }

        return $query;
    }
}