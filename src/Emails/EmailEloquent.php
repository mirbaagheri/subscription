<?php
namespace Mirbaagheri\Subscription\Emails;

use Illuminate\Database\Eloquent\Model;
use Config;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EmailEloquent extends Model implements EmailInterface{

    protected $table = 'subscription_emails';
    protected $config;
    protected $type;

    protected $fillable = [
        'email',
        'status',
    ];

    public function __construct(array $attributes = [])
    {
        $this->loadConfig();
        $this->loadTypeModel();
        parent::__construct($attributes);
    }

    private function loadConfig()
    {
        $this->config = Config::get('mirbaagheri.subscription');
    }

    private function loadTypeModel()
    {
        $this->type = resolve('subscription.types');
    }

    public function getStatusCodeByName($name)
    {
        return $this->config['emails']['status'][strtolower($name)];
    }

    public function getStatusAttribute($statusCode)
    {
        return array_search($statusCode, $this->config['emails']['status']);
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $this->config['emails']['status'][strtolower($value)];
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    public function types()
    {
        return $this->belongsToMany(
            'Mirbaagheri\Subscription\Types\TypeEloquent',
            'subscription_email_type',
            'email_id',
            'type_id')
            ->withTimestamps();
    }

    public function subscribe($typeName)
    {
        if(!$type = $this->type->findByName($typeName))
            throw new NotFoundHttpException('Type name does not exists!');
        if(!$this->types->contains($type->id)){
            $this->types()->attach($type->id);
        }
    }

    public function unsubscribe($typeName)
    {
        if(!$type = $this->type->findByName($typeName))
            throw new NotFoundHttpException('Type name does not exists!');
        $this->types()->detach($type->id);
    }
}
?>