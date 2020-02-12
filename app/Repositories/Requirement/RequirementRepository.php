<?php

namespace App\Repositories\Requirement;

interface RequirementRepository
{
	function getAll($request);

	function getById($id);

	function create(array $request);

	function update($id, array $request);

	function delete($id);
}