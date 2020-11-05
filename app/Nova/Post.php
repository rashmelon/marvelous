<?php

namespace App\Nova;

use App\Nova\Actions\Publish;
use App\Nova\Actions\UnPublish;
use Chaseconey\ExternalImage\ExternalImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;

class Post extends Resource
{
    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Content';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Post::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'title',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),

            BelongsTo::make('Source')
                ->nullable()
                ->rules('nullable', 'exists:sources,id'),

            BelongsTo::make('Commentary')
                ->nullable()
                ->rules('nullable', 'exists:commentaries,id')
                ->hideFromIndex(),

            Text::make('Title')
                ->displayUsing(function ($title) {
                    return Str::substr($title, 0, 50) . '...';
                })->onlyOnIndex(),

            Text::make('Title')
                ->rules('required', 'min:3')
                ->hideFromIndex(),

            Text::make('Source', 'source_url')
                ->rules('nullable', 'min:3', 'url')
                ->hideFromIndex(),

            ExternalImage::make('Image', 'image_url')
                ->width(30),

            Trix::make('Description')
                ->rules('required', 'min:10'),

            Boolean::make('Published', 'published'),

            Date::make('Published at')
                ->nullable()
                ->rules('nullable', 'date')
                ->hideFromIndex(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            Publish::make(),
            UnPublish::make(),
        ];
    }
}
