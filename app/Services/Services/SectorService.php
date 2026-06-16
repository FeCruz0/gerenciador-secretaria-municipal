<?php

namespace App\Services;

use App\Models\Sector;
use App\Repositories\RepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;

class SectorService
{
    private RepositoryInterface $sectorRepository;

    /**
     * SectorService constructor.
     * @param RepositoryInterface $sectorRepository
     */
    public function __construct(RepositoryInterface $sectorRepository)
    {
        $this->sectorRepository = $sectorRepository;
    }

    public function get()
    {
        return $this->sectorRepository->get();
    }

    public function create(array $request): Sector
    {
        return $this->sectorRepository->create($request);
    }

    public function show($id): Sector
    {
        return $this->sectorRepository->find($id);
    }

    public function update(array $request, $id): Sector
    {
        return $this->sectorRepository->update($id, $request);
    }

    public function delete($id): Sector
    {
        return $this->sectorRepository->delete($id);
    }

    public function restore($id): Sector
    {
        return $this->sectorRepository->restore($id);
    }

    public function forceDelete($id): Sector
    {
        return $this->sectorRepository->forceDelete($id);
    }

    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null): Paginator
    {
        return $this->sectorRepository->paginate($perPage, $columns, $pageName, $page);
    }
}
