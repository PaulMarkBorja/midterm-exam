<?php

namespace App\Repositories\Driver;

interface DriverEmergencyContactRepository
{
	function getAll($request);

	function getById($id);

	function create(array $request);

	function update($id, array $request);

	function delete($id);
}