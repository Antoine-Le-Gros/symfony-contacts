<?php

namespace App\Tests\Controller\Contact;

use App\Factory\ContactFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;
use Codeception\Util\HttpCode;

class DeleteCest
{
    public function formShowsContactDataBeforeUpdating(ControllerTester $I): void
    {
        $user = UserFactory::createOne([
            'roles' => ['ROLE_ADMIN'],
        ])->object();
        $I->amLoggedInAs($user);
    }

    public function accessIsRestrictedToAuthenticatedUsers(ControllerTester $I): void
    {
        ContactFactory::createOne([
            'firstname' => 'Homer',
            'lastname' => 'Simpson',
        ]);
        $I->amOnPage('/contact/1/delete');
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
        $I->amOnPage('/contact/1/delete');
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }
}
