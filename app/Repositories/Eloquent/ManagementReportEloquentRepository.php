<?php

namespace App\Repositories\Eloquent;

use App\Models\ManagementReport;
use App\Repositories\EloquentRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ManagementReportEloquentRepository extends EloquentRepository
{
    public function __construct()
    {
        parent::__construct(new ManagementReport());
    }

    public function get(): Collection
    {
        return parent::get();
    }

    public function create($data): ManagementReport | Model
    {
        return parent::create($data);
    }

    public function find($id): ManagementReport | Model
    {
        return parent::find($id);
    }

    public function withTrashed(): Builder
    {
        return parent::withTrashed();
    }

    public function update($id, $data): ManagementReport | Model
    {
        return parent::update($id, $data);
    }

    public function delete($id): ManagementReport | Model
    {
        return parent::delete($id);
    }

    public function restore($id): ManagementReport | Model
    {
        return parent::restore($id);
    }

    public function forceDelete($id): ManagementReport | Model
    {
        return parent::forceDelete($id);
    }

    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null): Paginator
    {
        return parent::paginate($perPage, $columns, $pageName, $page);
    }
}
