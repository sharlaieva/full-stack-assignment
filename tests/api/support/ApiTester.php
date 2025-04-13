<?php

declare(strict_types=1);

namespace wnd\appStub\tests\api\support;

use wnd\appStub\tests\api\support\_generated\ApiTesterActions;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
 */
class ApiTester extends \Codeception\Actor
{
    use ApiTesterActions;

    /**
     * Function deletes content-type, which sometimes remains in global variables after POST/PATCH functions etc. and GET fails
     *
     * @param array<string, mixed> $params
     */
    public function sendGetWithoutContentType(
        string $url,
        array $params = [],
        ?string $accept = null,
    ): mixed {
        $this->unsetHttpHeader('Content-Type');

        if ($accept !== null) {
            $this->setHeader('accept', $accept);
        }

        return $this->sendGet($url, $params);
    }
}
