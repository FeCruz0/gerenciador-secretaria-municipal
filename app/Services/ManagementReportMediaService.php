<?php

namespace App\Services;

use App\Models\ManagementReportMedia;
use App\Repositories\RepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;

class ManagementReportMediaService
{
    private RepositoryInterface $managementReportMediaRepository;

    /**
     * ManagementReportMediaService constructor.
     * @param RepositoryInterface $managementReportMediaRepository
     */
    public function __construct(RepositoryInterface $managementReportMediaRepository)
    {
        $this->managementReportMediaRepository = $managementReportMediaRepository;
    }

    public function get()
    {
        return $this->managementReportMediaRepository->get();
    }

    public function create(array $request): ManagementReportMedia
    {
        return $this->managementReportMediaRepository->create($request);
    }

    public function show($id): ManagementReportMedia
    {
        return $this->managementReportMediaRepository->find($id);
    }

    public function update(array $request, $id): ManagementReportMedia
    {
        return $this->managementReportMediaRepository->update($id, $request);
    }

    public function delete($id): ManagementReportMedia
    {
        return $this->managementReportMediaRepository->delete($id);
    }

    public function restore($id): ManagementReportMedia
    {
        return $this->managementReportMediaRepository->restore($id);
    }

    public function forceDelete($id): ManagementReportMedia
    {
        return $this->managementReportMediaRepository->forceDelete($id);
    }

    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null): Paginator
    {
        return $this->managementReportMediaRepository->paginate($perPage, $columns, $pageName, $page);
    }
}
