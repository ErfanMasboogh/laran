<?php

namespace ErfanMasboogh\Laran\Repositories\Manager;

use ErfanMasboogh\Laran\Models\Manager;

interface ManagerRepositoryInterface
{
    public function create(array $data, string $imageSID = null);
    public function update(Manager $manager, array $data, string $imageSID = null);
    public function delete(Manager $manager);
}