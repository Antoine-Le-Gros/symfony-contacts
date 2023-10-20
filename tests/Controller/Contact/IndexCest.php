<?php

namespace App\Tests\Controller\Contact;

use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function _before(ControllerTester $I)
    {
    }

    // tests
    public function tryToTest(ControllerTester $I)
    {
        $I->amOnPage('/contact');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Liste des contacts');
        $I->see('Liste des contacts', 'h1');
    }

    public function ListLenght(ControllerTester $I)
    {
        $I->amOnPage('/contact');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Liste des contacts');
        $I->see('Liste des contacts', 'h1');
        $I->seeNumberOfElements('li', 195);
    }

    public function firstLinkContact(ControllerTester $I)
    {
        $I->amOnPage('/contact');
        $I->seeResponseCodeIsSuccessful();
        $I->click('Andre, Sébastien');
        $I->seeCurrentRouteIs('app_contact_show');
    }
}
