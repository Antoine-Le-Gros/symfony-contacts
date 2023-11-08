<?php

namespace App\Tests\Controller\Contact;

use App\Factory\ContactFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function _before(ControllerTester $I)
    {
    }

    // tests
    public function tryToTest(ControllerTester $I): void
    {
        $I->amOnPage('/contact');
        $I->seeResponseCodeIsSuccessful(200);
        $I->seeInTitle('Liste des contacts');
        $I->see('Liste des contacts', 'h1');
    }

    public function ListLenght(ControllerTester $I): void
    {
        ContactFactory::createMany(50);
        $I->amOnPage('/contact');
        $I->seeResponseCodeIsSuccessful(200);
        $I->seeInTitle('Liste des contacts');
        $I->see('Liste des contacts', 'h1');
        $I->seeNumberOfElements('li', 50);
    }

    public function firstLinkContact(ControllerTester $I): void
    {
        ContactFactory::createOne(['firstname' => 'Joe', 'lastname' => 'Aaaaaaaaaaaaaaa']);
        ContactFactory::createMany(5);
        $I->amOnPage('/contact');
        $I->seeResponseCodeIsSuccessful(200);
        $I->click('Aaaaaaaaaaaaaaa, Joe');
        $I->seeCurrentRouteIs('app_contact_show');
    }

    public function ListContactSorted(ControllerTester $I): void
    {
        ContactFactory::createSequence(
            [
                ['firstname' => 'Henry', 'lastname' => 'Zwz'],
                ['firstname' => 'Antoine', 'lastname' => 'Le Gros'],
                ['firstname' => 'Zoe', 'lastname' => 'Aba'],
                ['firstname' => 'Pierre', 'lastname' => 'Gouedar'],
            ]
        );
        $I->amOnPage('/contact');
        $I->seeResponseCodeIsSuccessful(200);
        $text = $I->grabMultiple('ul.contacts li a[href]');
        $I->assertEquals(['Aba, Zoe', 'Gouedar, Pierre', 'Le Gros, Antoine', 'Zwz, Henry'], $text);
    }

    public function search(ControllerTester $I): void
    {
        ContactFactory::createSequence(
            [
                ['firstname' => 'Charles', 'lastname' => 'AUBRY'],
                ['firstname' => 'Charles', 'lastname' => 'ab'],
                ['firstname' => 'Charles', 'lastname' => 'av'],
                ['firstname' => 'Charles', 'lastname' => 'ad'],
            ]
        );
        $I->amOnPage('/contact?search=charles');
        $text = $I->grabMultiple('ul.contacts li a[href]');
        $I->assertEquals(['AUBRY, Charles', 'ab, Charles', 'ad, Charles', 'av, Charles'], $text);
        $I->seeNumberOfElements('li', 4);
    }
}
