<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class QueryBuilder extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\QueryBuilder>
     */
    public static $model = \App\Models\QueryBuilder::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name',
    ];

    /**
     * Label method
     *
     * @return string
     */
    public static function label(): string
    {
        return 'Query Builder';
    }

    /**
     * UriKey method
     *
     * @return string
     */
    public static function uriKey()
    {
        return 'query-builder';
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Parent', 'parent', static::class)
                ->sortable()
                ->nullable()
                ->withoutTrashed(),

            Text::make('Name')
                ->sortable()
                ->rules('required'),

            Select::make('Condition')
                ->sortable()
                ->rules(['required', 'in:and,or'])
                ->displayUsingLabels()
                ->options(fn () => [
                    ['value' => 'and', 'label' => 'And'],
                    ['value' => 'or', 'label' => 'Or'],
                ]),

            Select::make('Operator')
                ->sortable()
                ->rules(['required', 'in:eq,ne,in'])
                ->displayUsingLabels()
                ->options(fn () => [
                    ['value' => 'eq', 'label' => 'Equals'],
                    ['value' => 'ne', 'label' => 'Not Equals'],
                    ['value' => 'in', 'label' => 'In'],
                ]),

            Text::make('Field')
                ->sortable()
                ->rules('required'),

            Text::make('Value')
                ->sortable()
                ->rules('required'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }

    /**
     * RelatableParent method
     *
     * @param NovaRequest $request
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function relatableParent(NovaRequest $request, $query)
    {
        $resourceId = $request->route('resourceId');

        return $query->whereNotIn('id', [$resourceId]);
    }

    /**
     * RelatableParents method
     *
     * @param NovaRequest $request
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function relatableParents(NovaRequest $request, $query)
    {
        $resourceId = $request->route('resourceId');

        return $query->whereNotIn('id', [$resourceId]);
    }
}
