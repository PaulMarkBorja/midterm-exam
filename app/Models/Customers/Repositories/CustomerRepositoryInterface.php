<?php

namespace App\Models\Customers\Repositories;

use App\Models\Base\BaseRepositoryInterface;
use App\Models\Customers\Customer;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

interface CustomerRepositoryInterface extends BaseRepositoryInterface
{
    public function createCustomer(array $data): Customer;

    public function findCustomerById(int $id) : Customer;

    public function updateCustomer(array $data) : bool;

    public function deleteCustomer() : bool;

    public function listCustomers($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;

    function getAllCustomers(Request $request);
}
