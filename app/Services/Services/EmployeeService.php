<?php

namespace App\Services;

use App\Models\Employee;
use App\Repositories\RepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;

class EmployeeService
{
    private RepositoryInterface $employeeRepository;

    public function __construct(RepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function get()
    {
        return $this->employeeRepository->get();
    }

    public function create(array $request): Employee
    {
        return $this->employeeRepository->create($request);
    }

    public function show($id): Employee
    {
        return $this->employeeRepository->find($id);
    }

    public function update(array $request, $id): Employee
    {
        return $this->employeeRepository->update($id, $request);
    }

    public function delete($id): Employee
    {
        return $this->employeeRepository->delete($id);
    }

    public function restore($id): Employee
    {
        return $this->employeeRepository->restore($id);
    }

    public function forceDelete($id): Employee
    {
        return $this->employeeRepository->forceDelete($id);
    }

    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null): Paginator
    {
        return $this->employeeRepository->paginate($perPage, $columns, $pageName, $page);
    }
}
