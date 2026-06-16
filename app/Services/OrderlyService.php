<?php

namespace App\Services;

use App\Models\Orderly;
use App\Repositories\RepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;

class OrderlyService
{
    private RepositoryInterface $orderlyRepository;

    /**
     * OrderlyService constructor.
     * @param RepositoryInterface $orderlyRepository
     */
    public function __construct(RepositoryInterface $orderlyRepository)
    {
        $this->orderlyRepository = $orderlyRepository;
    }

    public function get()
    {
        return $this->orderlyRepository->get();
    }

    public function create(array $request): Orderly
    {
        return $this->orderlyRepository->create($request);
    }

    public function show($id): Orderly
    {
        return $this->orderlyRepository->find($id);
    }

    public function update(array $request, $id): Orderly
    {
        return $this->orderlyRepository->update($id, $request);
    }

    public function delete($id): Orderly
    {
        return $this->orderlyRepository->delete($id);
    }

    public function restore($id): Orderly
    {
        return $this->orderlyRepository->restore($id);
    }

    public function forceDelete($id): Orderly
    {
        return $this->orderlyRepository->forceDelete($id);
    }

    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null): Paginator
    {
        return $this->orderlyRepository->paginate($perPage, $columns, $pageName, $page);
    }
}
