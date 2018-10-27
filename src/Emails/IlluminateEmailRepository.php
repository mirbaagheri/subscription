<?php
namespace Mirbaagheri\Subscription\Emails;

use InvalidArgumentException;
use Validator;
use Cartalyst\Support\Traits\EventTrait;
use Cartalyst\Support\Traits\RepositoryTrait;

class IlluminateEmailRepository implements EmailRepositoryInterface
{
    use EventTrait, RepositoryTrait;

    protected $model = 'Mirbaagheri\Subscription\Emails\EmailEloquent';

    public function __construct($model = null)
    {
        if (isset($model)) {
            $this->model = $model;
        }
    }

    protected function validation($input)
    {
        $validation = Validator::make($input,['email' => 'required|email','status'=>'emailStatus']);

        if($validation->fails())
            foreach($validation->errors()->all() as $Exception)
            {
                throw new InvalidArgumentException($Exception);
            }
    }

    /* Find a Email By ID  */
    public function findById($id)
    {
        $q = $this->createModel();
        $q = $q->find($id);
        return $q;
    }

    // Find Email By Address
    public function findByAddress($email)
    {
        if($validation = $this->validation(['email' => $email]))
            return $validation;

        $q = $this->createModel();
        $q = $q->where('email','=',$email);
        return $q->first();
    }

    // Find Email(s) By Status
    public function findByStatus($status)
    {
        return $this
            ->createModel()
            ->newQuery()
            ->where('status',$this->getStatusCodeByName($status))
            ->get();
    }

    // Add Email to Database Bank
    public function add($array)
    {
        if($validation = $this->validation($array))
            return $validation;

        // Check duplicate record in database
        if($this->FindByAddress($array['email'])) {
            throw new InvalidArgumentException('Record exist! Duplicate email can not allowed!');
        }

        $query = $this->createModel();
        $query = $query->create($array);
        return $query;
    }

    // Update Email
    public function update(EmailEloquent $eloquentEmail, array $newData)
    {
            $q = $eloquentEmail;
            $q = $q->fill($newData);
            $q = $q->save();
            return $q;

    }

    // Delete Email
    public function destroy($id)
    {
        $q = $this->createModel();
        $q = $q->findOrFail($id);
        $q = $q->delete();
        return $q;
    }

}
