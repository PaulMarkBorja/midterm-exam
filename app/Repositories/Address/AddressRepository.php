<?php

namespace App\Repositories\Address;

interface AddressRepository
{
	function getAll($request);

	function getById($id);

	function create(array $request);

	function update($id, array $request);

	function delete($id);
}