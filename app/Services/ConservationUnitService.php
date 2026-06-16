<?php

namespace App\Services;

use App\Models\ConservationUnit;
use App\Repositories\RepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;

class ConservationUnitService
{
    private RepositoryInterface $ConservationUnitRepository;

    /**
     * ConservationUnitService constructor.
     * @param RepositoryInterface $ConservationUnitRepository
     */
    public function __construct(RepositoryInterface $ConservationUnitRepository)
    {
        $this->ConservationUnitRepository = $ConservationUnitRepository;
    }

    public function get()
    {
        return $this->ConservationUnitRepository->get();
    }

    public function create(array $request): ConservationUnit
    {
        return $this->ConservationUnitRepository->create($request);
    }

    public function show($id): ConservationUnit
    {
        return $this->ConservationUnitRepository->find($id);
    }

    public function update(array $request, $id): ConservationUnit
    {
        return $this->ConservationUnitRepository->update($id, $request);
    }

    public function delete($id): ConservationUnit
    {
        return $this->ConservationUnitRepository->delete($id);
    }

    public function restore($id): ConservationUnit
    {
        return $this->ConservationUnitRepository->restore($id);
    }

    public function forceDelete($id): ConservationUnit
    {
        return $this->ConservationUnitRepository->forceDelete($id);
    }

    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null): Paginator
    {
        return $this->ConservationUnitRepository->paginate($perPage, $columns, $pageName, $page);
    }
}
