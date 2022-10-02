<?php

namespace Tests\Functional\Vk;

use Tests\Support\FunctionalTester;

class GiveMePillsCommandCest {

    /**
     * @param FunctionalTester $I
     * @return void
     */
    public function tryToGiveMePills(FunctionalTester $I): void
    {
        $I->wantToTest('Дай таблетки');
        $I->sendVkMessage('Слава дай таблетки');
        $I->waitVkResponse();
        $I->seeVkBotImage();
    }
}
