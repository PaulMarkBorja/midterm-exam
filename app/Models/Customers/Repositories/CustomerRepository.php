<?php

namespace App\Models\Customers\Repositories;

use App\Models\Base\BaseRepository;
use App\Models\Customers\Customer;
use App\Models\Customers\Exceptions\CustomerNotFoundErrorException;
use App\Models\Customers\Exceptions\CreateCustomerErrorException;
use App\Models\Customers\Exceptions\UpdateCustomerErrorException;
use App\Models\Customers\Exceptions\DeleteCustomerErrorException;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    /**
     * CustomerRepository constructor.
     *
     * @param Customer $customer
     */
    public function __construct(Customer $customer)
    {
        parent::__construct($customer);
        $this->model = $customer;
    }

    /**
     * @param array $data
     *
     * @return Customer
     * @throws CreateCustomerErrorException
     */
    public function createCustomer(array $data): Customer
    {
        try {
            $data['password'] = bcrypt('12345678');
            $data['name'] = $data['first_name'] . ' ' . $data['last_name'];
            $user = User::create($data);
            $user->save();
            $user->assignRole(['Customer']);

            $data['user_id'] = $user->id;
            return $this->create($data);
        } catch (QueryException $e) {
            throw new CreateCustomerErrorException($e);
        }
    }

    /**
     * @param int $id
     *
     * @return Customer
     * @throws CustomerNotFoundErrorException
     */
    public function findCustomerById(int $id): Customer
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new CustomerNotFoundErrorException($e);
        }
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return bool
     * @throws UpdateCustomerErrorException
     */
    public function updateCustomer(array $data): bool
    {
        try {
            return $this->update($data);
        } catch (QueryException $e) {
            throw new UpdateCustomerErrorException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteCustomer(): bool
    {

        try {
            return $this->delete();
        } catch (QueryException $e) {
            throw new DeleteCustomerErrorException($e);
        }
    }

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     *
     * @return Collection
     */
    public function listCustomers($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc'): Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }

    public function getAllCustomers(Request $request)
    {
        $r = $request;

        if (isset($r["sort"])) {
            $sort = explode("|", $r["sort"]);
        }
        if (isset($r["filter"])) {
            $customers = $this->model->where('first_name', 'like', '%' . $r["filter"] . '%')
                ->orWhere('last_name', 'like', '%' . $r["filter"] . '%')
                ->orWhere('phone', 'like', '%' . $r["filter"] . '%')
                ->orderBy($sort[0], $sort[1])->paginate(5);
        } else if (!isset($r["sort"])) {
            $customers = $this->model->paginate(5);
            return response()->json(compact('customers'));
        } else {
            //$customers = $this->model->orderBy( $sort[0] ,$sort[1])->paginate(5);
            $customers = $this->model->latest()->paginate(5);
        }

        return $customers;
    }
}
