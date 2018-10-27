<?php

namespace Mirbaagheri\Subscription\Types;

trait  TypesTrait
{
    /**
     * Create a new type for subscription types.
     *
     * @param  array $array
     * @return object
     */
    public function createType(array $array)
    {
        $this->ReflectionMethod(__FUNCTION__);

        foreach ($this->params as $param) {
            $data[] = ${$param};
        }

        return $this->__call(__FUNCTION__ ,$data);
    }

    public function destroyType($id)
    {
        $this->ReflectionMethod(__FUNCTION__);

        foreach ($this->params as $param) {
            $data[] = ${$param};
        }

        return $this->__call(__FUNCTION__ ,$data);
    }

    public function findTypeById($id)
    {
        $this->ReflectionMethod(__FUNCTION__);

        foreach ($this->params as $param) {
            $data[] = ${$param};
        }

        return $this->__call(__FUNCTION__ ,$data);
    }

    public function findTypeByName($name)
    {
        $this->ReflectionMethod(__FUNCTION__);

        foreach ($this->params as $param) {
            $data[] = ${$param};
        }

        return $this->__call(__FUNCTION__ ,$data);
    }

    public function findTypeByStatus($status)
    {
        $this->ReflectionMethod(__FUNCTION__);

        foreach ($this->params as $param) {
            $data[] = ${$param};
        }

        return $this->__call(__FUNCTION__ ,$data);
    }

    public function updateType(array $array)
    {
        $this->ReflectionMethod(__FUNCTION__);

        foreach ($this->params as $param) {
            $data[] = ${$param};
        }

        return $this->__call(__FUNCTION__ ,$data);
    }
}
