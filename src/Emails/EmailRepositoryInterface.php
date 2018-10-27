<?php

namespace Mirbaagheri\Subscription\Emails;

interface EmailRepositoryInterface
{
    public function add($array);
    public function destroy($id);
    public function findById($id);
    public function findByAddress($emailAddress);
    public function findByStatus($status);
    public function update(EmailEloquent $eloquent, array $newData);
}
