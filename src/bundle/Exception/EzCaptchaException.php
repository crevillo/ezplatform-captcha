<?php

namespace Crevillo\EzCaptchaBundle\Exception;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

class EzCaptchaException extends AuthenticationException
{
    public function getMessageKey()
    {
        return 'Wrong captcha code';
    }
}
