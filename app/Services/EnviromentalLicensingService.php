<?php

namespace App\Services;

use App\Models\EnviromentalLicensing;
use App\Repositories\RepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;

class EnviromentalLicensingService
{
    private RepositoryInterface $enviromentalLicensingRepository;

    /**
     * EnviromentalLicensingService constructor.
     * @param RepositoryInterface $enviromentalLicensingRepository
     */
    public function __construct(RepositoryInterface $enviromentalLicensingRepository)
    {
        $this->enviromentalLicensingRepository = $enviromentalLicensingRepository;
    }

    public function get()
    {
        return $this->enviromentalLicensingRepository->get();
    }

    public function create(array $request): EnviromentalLicensing
    {
        return $this->enviromentalLicensingRepository->create($request);
    }

    public function show($id): EnviromentalLicensing
    {
        return $this->enviromentalLicensingRepository->find($id);
    }

    public function update(array $request, $id): EnviromentalLicensing
    {
        return $this->enviromentalLicensingRepository->update($id, $request);
    }

    public function delete($id): EnviromentalLicensing
    {
        return $this->enviromentalLicensingRepository->delete($id);
    }

    public function restore($id): EnviromentalLicensing
    {
        return $this->enviromentalLicensingRepository->restore($id);
    }

    public function forceDelete($id): EnviromentalLicensing
    {
        return $this->enviromentalLicensingRepository->forceDelete($id);
    }

    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null): Paginator
    {
        return $this->enviromentalLicensingRepository->paginate($perPage, $columns, $pageName, $page);
    }
}
