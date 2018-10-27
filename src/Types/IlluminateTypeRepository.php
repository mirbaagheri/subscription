<?php
namespace Mirbaagheri\Subscription\Types;

use InvalidArgumentException;
use Validator;
use Cartalyst\Support\Traits\EventTrait;
use Cartalyst\Support\Traits\RepositoryTrait;

class IlluminateTypeRepository implements TypeRepositoryInterface
{
    use EventTrait, RepositoryTrait;

    protected $model = 'Mirbaagheri\Subscription\Types\TypeEloquent';
    protected $config;

    public function __construct($model = null)
    {
        if (isset($model)) {
            $this->model = $model;
        }
    }

    protected function MakeServerModel(){
        return $this->createModel();
    }

    protected function validation($input)
    {
        $validation = Validator::make($input,['name' => 'required','status'=>'typeStatus']);

        if($validation->fails())
            foreach($validation->errors()->all() as $Exception)
            {
                throw new InvalidArgumentException($Exception);
            }
    }

    /* Find a type by id  */
    public function findById($id)
    {
        $q = $this->createModel();
        $q = $q->find($id);
        return $q;
    }

    // Find type by name
    public function findByName($name)
    {
        if($validation = $this->validation(['name' => $name]))
            return $validation;

        $q = $this->createModel();
        $q = $q->where('name','=',$name);
        return $q->first();
    }

    // Find type(s) By Status Code
    public function findByStatus($status)
    {
        return $this
            ->createModel()
            ->newQuery()
            ->where('status',$this->getStatusCodeByName($status))
            ->get();
    }

    // Create subscription type.
    public function create($array)
    {
        if($validation = $this->validation($array))
            return $validation;

        // Check duplicate record in database
        if($this->FindByName($array['name'])) {
            throw new InvalidArgumentException('Record exist! Duplicate type can not allowed!');
        }

        $q = $this->createModel();
        $q = $q->create($array);
        return $q;
    }

    // Update subscription type
    public function update(TypeEloquent $eloquentType, array $newData)
    {
        $q = $eloquentType;
        $q = $q->fill($newData);
        $q = $q->save();
        return $q;
    }

    // Delete a subscription type
    public function destroy($id)
    {
        $q = $this->createModel();
        $q = $q->findOrFail($this->id);
        $q = $q->delete();
        return $q;
    }
}
