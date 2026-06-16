<?php

namespace App\Services;

use App\Models\PeoplePeopleType;
use App\Repositories\RepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;

class PeoplePeopleTypeService
{
    private RepositoryInterface $peoplePeopleTypeRepository;

    /**
     * peoplePeopleTypeService constructor.
     * @param RepositoryInterface $peoplePeopleTypeRepository
     */
    public function __construct(RepositoryInterface $peoplePeopleTypeRepository)
    {
        $this->peoplePeopleTypeRepository = $peoplePeopleTypeRepository;
    }

    public function get()
    {
        return $this->peoplePeopleTypeRepository->get();
    }

    public function create(array $request): PeoplePeopleType
    {
        return $this->peoplePeopleTypeRepository->create($request);
    }

    public function show($id): PeoplePeopleType
    {
        return $this->peoplePeopleTypeRepository->find($id);
    }

    public function update(array $request, $id): PeoplePeopleType
    {
        return $this->peoplePeopleTypeRepository->update($id, $request);
    }

    public function delete($id): PeoplePeopleType
    {
        return $this->peoplePeopleTypeRepository->delete($id);
    }

    public function restore($id): PeoplePeopleType
    {
        return $this->peoplePeopleTypeRepository->restore($id);
    }

    public function forceDelete($id): PeoplePeopleType
    {
        return $this->peoplePeopleTypeRepository->forceDelete($id);
    }

    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null): Paginator
    {
        return $this->peoplePeopleTypeRepository->paginate($perPage, $columns, $pageName, $page);
    }
}
