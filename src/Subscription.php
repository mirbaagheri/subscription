<?php
namespace Mirbaagheri\Subscription;

use ReflectionMethod;
use BadMethodCallException;
use Mirbaagheri\Subscription\Emails\EmailRepositoryInterface;
use Mirbaagheri\Subscription\Emails\EmailsTrait;
use Mirbaagheri\Subscription\Types\TypeRepositoryInterface;
use Mirbaagheri\Subscription\Types\TypesTrait;

class Subscription
{
    use EmailsTrait, TypesTrait;

    private $params = [];

    protected $email;
    protected $EmailMethods;

    protected $type;
    protected $TypeMethods;

    protected $phone;
    protected$PhoneMethods;


    public function __construct(
        EmailRepositoryInterface $email,
        TypeRepositoryInterface $type)
    {
        $this->email    = $email;
        $this->type     = $type;
    }


    /**
     * Reflection.
     *
     * @param  string $funcName
     * @return null
     */
    private function ReflectionMethod($funcName)
    {
        $this->params = [];
        $Reflection = new ReflectionMethod($this,$funcName);
        foreach ($Reflection->getParameters() as $param) {
            $this->params[] = $param->name;
        }
    }

    public function getEmailRepository()
    {
        return $this->email;
    }

    protected function EmailMethods()
    {
        if (empty($this->EmailMethods)) {

            $repository = $this->getEmailRepository();

            $methods = get_class_methods($repository);

            $this->EmailMethods = array_diff($methods, ['__construct']);
        }

        return $this->EmailMethods;
    }

    public function getTypeRepository()
    {
        return $this->type;
    }

    protected function TypeMethods()
    {
        if (empty($this->TypeMethods)) {

            $repository = $this->getTypeRepository();
            $methods = get_class_methods($repository);
            $this->TypeMethods = array_diff($methods, ['__construct']);
        }

        return $this->TypeMethods;
    }

    protected function splitAtUpperCase($s) {
        return preg_split('/(?=[A-Z])/', $s, -1, PREG_SPLIT_NO_EMPTY);
    }

    public function __call($method, $parameters)
    {
        $M = $this->splitAtUpperCase($method);
        $methodName = $M[1].'Methods';
        $Repository_Name = 'get'.$M[1].'Repository';
        $methods = $this->$methodName();
        unset($M[1]);
        $method = implode($M);
        if (in_array($method, $methods)) {
            $CallMethod = $this->$Repository_Name();
            return call_user_func_array([$CallMethod, $method], $parameters);
        }

        throw new BadMethodCallException("Call to undefined method {$methodName}::{$method}()");
    }

}
