<?php

namespace App\Services;

use App\Models\ManagementReportType;
use App\Repositories\RepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;

class ManagementReportTypeService
{
    private RepositoryInterface $coverageRepository;

    /**
     * ManagementReportTypeService constructor.
     * @param RepositoryInterface $coverageRepository
     */
    public function __construct(RepositoryInterface $coverageRepository)
    {
        $this->coverageRepository = $coverageRepository;
    }

    public function get()
    {
        return $this->coverageRepository->get();
    }

    public function create(array $request): ManagementReportType
    {
        return $this->coverageRepository->create($request);
    }

    public function show($id): ManagementReportType
    {
        return $this->coverageRepository->find($id);
    }

    public function update(array $request, $id): ManagementReportType
    {
        return $this->coverageRepository->update($id, $request);
    }

    public function delete($id): ManagementReportType
    {
        return $this->coverageRepository->delete($id);
    }

    public function restore($id): ManagementReportType
    {
        return $this->coverageRepository->restore($id);
    }

    public function forceDelete($id): ManagementReportType
    {
        return $this->coverageRepository->forceDelete($id);
    }

    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null): Paginator
    {
        return $this->coverageRepository->paginate($perPage, $columns, $pageName, $page);
    }
}
