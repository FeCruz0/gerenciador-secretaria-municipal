<?php

namespace App\Services;

use App\Models\Type_request;
use App\Repositories\RepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;

class TypeRequestService
{
    private RepositoryInterface $TypeRequestRepository;

    /**
     * TypeRequestService constructor.
     * @param RepositoryInterface $TypeRequestRepository
     */
    public function __construct(RepositoryInterface $TypeRequestRepository)
    {
        $this->TypeRequestRepository = $TypeRequestRepository;
    }

    public function get()
    {
        return $this->TypeRequestRepository->get();
    }

    public function create(array $request): Type_request
    {
        return $this->TypeRequestRepository->create($request);
    }

    public function show($id): Type_request
    {
        return $this->TypeRequestRepository->find($id);
    }

    public function update(array $request, $id): Type_request
    {
        return $this->TypeRequestRepository->update($id, $request);
    }

    public function delete($id): Type_request
    {
        return $this->TypeRequestRepository->delete($id);
    }

    public function restore($id): Type_request
    {
        return $this->TypeRequestRepository->restore($id);
    }

    public function forceDelete($id): Type_request
    {
        return $this->TypeRequestRepository->forceDelete($id);
    }

    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null): Paginator
    {
        return $this->TypeRequestRepository->paginate($perPage, $columns, $pageName, $page);
    }
}
