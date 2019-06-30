<?php

namespace Crevillo\EzCaptchaBundle\Form\Extension;

use EzSystems\EzPlatformUser\Form\Type\UserPasswordForgotType;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

class UserPasswordForgotTypeExtension extends AbstractTypeExtension
{
    public function getExtendedType()
    {
        return UserPasswordForgotType::class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('captcha', CaptchaType::class);
    }
}
