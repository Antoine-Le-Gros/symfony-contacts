<?php

namespace App\Tests\Controller\Contact;

use App\Factory\ContactFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;
use Codeception\Util\HttpCode;

class CreateCest
{
    public function accessIsRestrictedToAuthenticatedUsers(ControllerTester $I): void
    {
        ContactFactory::createOne([
            'firstname' => 'Homer',
            'lastname' => 'Simpson',
        ]);
        $I->amOnPage('/contact/create');
        $I->seeCurrentRouteIs('app_login');
    }
    public function accessIsRestrictedToAdminUsers(ControllerTester $I): void
    {
        ContactFactory::createOne([
            'firstname' => 'Homer',
            'lastname' => 'Simpson',
        ]);
        $user = UserFactory::createOne([
            'roles' => ['ROLE_USER'],
        ])->object();
        $I->amLoggedInAs($user);
        $I->amOnPage('/contact/create');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeInTitle("Création d'un nouveau contact");
    }
}
