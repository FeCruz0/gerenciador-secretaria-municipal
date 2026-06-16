<?php

namespace App\Services;

use App\Models\Coverage;
use App\Repositories\RepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;

class CoverageService
{
    private RepositoryInterface $CoverageRepository;

    /**
     * CoverageService constructor.
     * @param RepositoryInterface $CoverageRepository
     */
    public function __construct(RepositoryInterface $CoverageRepository)
    {
        $this->CoverageRepository = $CoverageRepository;
    }

    public function get()
    {
        return $this->CoverageRepository->get();
    }

    public function create(array $request): Coverage
    {
        return $this->CoverageRepository->create($request);
    }

    public function show($id): Coverage
    {
        return $this->CoverageRepository->find($id);
    }

    public function update(array $request, $id): Coverage
    {
        return $this->CoverageRepository->update($id, $request);
    }

    public function delete($id): Coverage
    {
        return $this->CoverageRepository->delete($id);
    }

    public function restore($id): Coverage
    {
        return $this->CoverageRepository->restore($id);
    }

    public function forceDelete($id): Coverage
    {
        return $this->CoverageRepository->forceDelete($id);
    }

    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null): Paginator
    {
        return $this->CoverageRepository->paginate($perPage, $columns, $pageName, $page);
    }
}
