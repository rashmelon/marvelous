<?php


namespace App\Queries;


class QueryBuilder extends \Spatie\QueryBuilder\QueryBuilder
{

    public function paginateFromRequest()
    {
        $page = $this->request->input('page');

        $number = isset($page['number'])? $page['number']: null;
        $size = isset($page['size'])? $page['size']: null;

        return $this->paginate($size, ['*'], 'page', $number);
    }
}
