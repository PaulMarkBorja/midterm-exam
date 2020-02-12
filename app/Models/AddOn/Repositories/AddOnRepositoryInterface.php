<?php

namespace App\Models\AddOn\Repositories;

interface AddOnRepositoryInterface
{
	function getAll($request);

	function getById($id);

	function create(array $request);

	function update($id, array $request);

	function delete($id);
}