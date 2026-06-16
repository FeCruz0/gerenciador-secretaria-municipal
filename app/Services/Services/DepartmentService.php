<?php

namespace App\Services;

use App\Models\departament;
use App\Repositories\RepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;

class departamentService
{
    private RepositoryInterface $departamentRepository;

    /**
     * departamentService constructor.
     * @param RepositoryInterface $departamentRepository
     */
    public function __construct(RepositoryInterface $departamentRepository)
    {
        $this->departamentRepository = $departamentRepository;
    }

    public function get()
    {
        return $this->departamentRepository->get();
    }

    public function create(array $request): departament
    {
        return $this->departamentRepository->create($request);
    }

    public function show($id): departament
    {
        return $this->departamentRepository->find($id);
    }

    public function update(array $request, $id): departament
    {
        return $this->departamentRepository->update($id, $request);
    }

    public function delete($id): departament
    {
        return $this->departamentRepository->delete($id);
    }

    public function restore($id): departament
    {
        return $this->departamentRepository->restore($id);
    }

    public function forceDelete($id): departament
    {
        return $this->departamentRepository->forceDelete($id);
    }

    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null): Paginator
    {
        return $this->departamentRepository->paginate($perPage, $columns, $pageName, $page);
    }
}
