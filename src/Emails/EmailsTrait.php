<?php

namespace Mirbaagheri\Subscription\Emails;

trait  EmailsTrait
{
    /**
     * Add a new email to emails bank.
     *
     * @param  array $array Email
     * @return object
     */
    public function addEmail(array $array)
    {
        $this->ReflectionMethod(__FUNCTION__);

        foreach ($this->params as $param) {
            $data[] = ${$param};
        }
        return $this->__call(__FUNCTION__ ,$data);
    }

    public function destroyEmail($id)
    {
        $this->ReflectionMethod(__FUNCTION__);

        foreach ($this->params as $param) {
            $data[] = ${$param};
        }

        return $this->__call(__FUNCTION__ ,$data);
    }

    public function findEmailById($id)
    {
        $this->ReflectionMethod(__FUNCTION__);

        foreach ($this->params as $param) {
            $data[] = ${$param};
        }

        return $this->__call(__FUNCTION__ ,$data);
    }

    public function findEmailByAddress($emailAddress)
    {
        $this->ReflectionMethod(__FUNCTION__);

        foreach ($this->params as $param) {
            $data[] = ${$param};
        }

        return $this->__call(__FUNCTION__ ,$data);
    }

    public function findEmailByStatus($status)
    {
        $this->ReflectionMethod(__FUNCTION__);

        foreach ($this->params as $param) {
            $data[] = ${$param};
        }

        return $this->__call(__FUNCTION__ ,$data);
    }

    public function updateEmail(EmailEloquent $eloquentObject, array $newData)
    {
        $this->ReflectionMethod(__FUNCTION__);

        foreach ($this->params as $param) {
            $data[] = ${$param};
        }

        return $this->__call(__FUNCTION__ ,$data);
    }
}
