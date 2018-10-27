<?php
namespace Mirbaagheri\Subscription\Types;

use Illuminate\Database\Eloquent\Model;
use Config;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TypeEloquent extends Model implements TypeInterface{

    protected $table = 'subscription_types';
    protected $config;
    protected $email;

    protected $fillable = [
        'name',
        'status',
    ];

    public function __construct(array $attributes = array())
    {
        $this->loadConfig();
        $this->loadEmailModel();
        parent::__construct($attributes);
    }

    private function loadConfig()
    {
        $this->config = Config::get('mirbaagheri.subscription');
    }

    private function loadEmailModel()
    {
        $this->email = resolve('subscription.emails');
    }

    public function getStatusCodeByName($name)
    {
        return $this->config['types']['status'][strtolower($name)];
    }

    public function getStatusAttribute($statusCode)
    {
        return array_search($statusCode, $this->config['types']['status']);
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $this->config['types']['status'][strtolower($value)];
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }

    public function emails()
    {
        return $this->belongsToMany(
            'Mirbaagheri\Subscription\Emails\EmailEloquent',
            'subscription_email_type',
            'type_id',
            'email_id')
            ->withTimestamps();
    }

    public function subscribe($emailAddress)
    {
        if(!$email = $this->email->findByAddress($emailAddress))
            throw new NotFoundHttpException('Email does not exists!');
        if(!$this->emails->contains($email->id)){
            $this->emails()->attach($email->id);
        }
    }

    public function unsubscribe($emailAddress)
    {
        if(!$email = $this->email->findByAddress($emailAddress))
            throw new NotFoundHttpException('Email does not exists!');
        $this->emails()->detach($email->id);
    }
}
?>