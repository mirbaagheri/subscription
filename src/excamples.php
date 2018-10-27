<?php
use Subscription;

/* Add Email To database */
        $add = Subscription::addEmail(['email' => 'mostafa20@yahoo.com', 'status' => 'invalid']);

/* Find an email from database */
        $subscriptionEmail = Subscription::findEmailByAddress('nEw2@yahoo.com');
        $subscriptionEmail = Subscription::findEmailById(30);
        $subscriptionEmail = Subscription::findEmailByStatus('invalid');


/* Update an email */
        $updateEmail = Subscription::updateEmail($subscriptionEmail, ['email' => 'mostafa.miri65@yahoo.com', 'status' => 'verified']);


/* Delete an email */
        $subscriptionEmail = Subscription::findEmailById(30);
        $subscriptionEmail->delete();
        Subscription::destroyEmail('33');










/* Type Eloquent*/
        $type = Subscription::createType(['name' =>'systematic2','status' => 'active']);
        $type = Subscription::findTypeById(2);
        $type = Subscription::findTypeByName('offers');
        $type = Subscription::findTypeByStatus('disable');









/* Subscribe & UnSubscribe by email eloquent */
        $email = Subscription::findEmailByAddress('mostafa@yahoo.com');
        $email->subscribe('systematic');
        $email->unsubscribe('systematic');










/* Subscribe & UnSubscribe by type eloquent */
        $type = Subscription::findTypeByname('systematic');
        $type->subscribe('beshkanweb2@gmail.com');
        $type->unsubscribe('beshkanweb@gmail.com');