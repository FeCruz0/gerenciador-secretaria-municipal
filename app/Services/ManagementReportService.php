<?php

namespace App\Services;

use App\Models\ManagementReport;
use App\Repositories\RepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;

class ManagementReportService
{
    private RepositoryInterface $managementReportRepository;

    /**
     * ManagementReportService constructor.
     * @param RepositoryInterface $managementReportRepository
     */
    public function __construct(RepositoryInterface $managementReportRepository)
    {
        $this->managementReportRepository = $managementReportRepository;
    }

    public function get()
    {
        return $this->managementReportRepository->get();
    }

    public function create(array $request): ManagementReport
    {
        return $this->managementReportRepository->create($request);
    }

    public function show($id): ManagementReport
    {
        return $this->managementReportRepository->find($id);
    }

    public function update(array $request, $id): ManagementReport
    {
        return $this->managementReportRepository->update($id, $request);
    }

    public function delete($id): ManagementReport
    {
        return $this->managementReportRepository->delete($id);
    }

    public function restore($id): ManagementReport
    {
        return $this->managementReportRepository->restore($id);
    }

    public function forceDelete($id): ManagementReport
    {
        return $this->managementReportRepository->forceDelete($id);
    }

    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null): Paginator
    {
        return $this->managementReportRepository->paginate($perPage, $columns, $pageName, $page);
    }
}
