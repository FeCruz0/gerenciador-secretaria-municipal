<?php

namespace App\Services;

use App\Models\Type_access;
use App\Repositories\RepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;

class TypeAccessService
{
    private RepositoryInterface $TypeAccessRepository;

    /**
     * TypeAccessService constructor.
     * @param RepositoryInterface $TypeAccessRepository
     */
    public function __construct(RepositoryInterface $TypeAccessRepository)
    {
        $this->TypeAccessRepository = $TypeAccessRepository;
    }

    public function get()
    {
        return $this->TypeAccessRepository->get();
    }

    public function create(array $request): Type_access
    {
        return $this->TypeAccessRepository->create($request);
    }

    public function show($id): Type_access
    {
        return $this->TypeAccessRepository->find($id);
    }

    public function update(array $request, $id): Type_access
    {
        return $this->TypeAccessRepository->update($id, $request);
    }

    public function delete($id): Type_access
    {
        return $this->TypeAccessRepository->delete($id);
    }

    public function restore($id): Type_access
    {
        return $this->TypeAccessRepository->restore($id);
    }

    public function forceDelete($id): Type_access
    {
        return $this->TypeAccessRepository->forceDelete($id);
    }

    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null): Paginator
    {
        return $this->TypeAccessRepository->paginate($perPage, $columns, $pageName, $page);
    }
}
