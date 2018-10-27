<?php

namespace Mirbaagheri\Subscription\Types;

interface TypeRepositoryInterface
{
    public function create($array);
    public function destroy($id);
    public function findById($id);
    public function findByName($name);
    public function findByStatus($status);
    public function update(TypeEloquent $eloquent, array $newData);
}
