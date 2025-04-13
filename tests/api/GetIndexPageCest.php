<?php

declare(strict_types=1);

namespace wnd\appStub\tests\api;

use Codeception\Util\HttpCode;
use wnd\appStub\tests\api\support\ApiTester;

class GetIndexPageCest
{
	public function shouldReturnIndexPage(ApiTester $I): void
	{
		$I->sendGet('/');
		$I->seeResponseCodeIs(HttpCode::OK);
		$I->seeResponseContains('Welcome!');
	}
}
