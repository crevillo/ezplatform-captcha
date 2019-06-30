<?php declare(strict_types=1);

namespace Crevillo\EzCaptchaBundle\MVC\Symfony\Controller;

use eZ\Bundle\EzPublishCoreBundle\Controller;
use eZ\Publish\Core\MVC\ConfigResolverInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Templating\EngineInterface;
use Crevillo\EzCaptchaBundle\Captcha\Builder;

class SecurityController extends Controller
{
    /**
     * @var \Symfony\Component\Templating\EngineInterface
     */
    protected $templateEngine;

    /**
     * @var \eZ\Publish\Core\MVC\ConfigResolverInterface
     */
    protected $configResolver;

    /**
     * @var \Symfony\Component\Security\Http\Authentication\AuthenticationUtils
     */
    protected $authenticationUtils;

    /**
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    protected $requestStack;

    /**
     * @var \Crevillo\EzCaptchaBundle\Captcha\Builder
     */
    protected $builder;

    public function __construct(
        EngineInterface $templateEngine,
        ConfigResolverInterface $configResolver,
        AuthenticationUtils $authenticationUtils,
        RequestStack $requestStack,
        Builder $builder
    ) {
        $this->templateEngine = $templateEngine;
        $this->configResolver = $configResolver;
        $this->authenticationUtils = $authenticationUtils;
        $this->requestStack = $requestStack;
        $this->builder = $builder;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response;
     */
    public function loginAction()
    {
        $captcha = $this->builder->build();
        $session = $this->requestStack->getCurrentRequest()->getSession();
        $session->set('captcha_phrase', $captcha->getPhrase());

        return new Response(
            $this->templateEngine->render(
                $this->configResolver->getParameter('security.login_template'),
                [
                    'last_username' => $this->authenticationUtils->getLastUsername(),
                    'error' => $this->authenticationUtils->getLastAuthenticationError(),
                    'layout' => $this->configResolver->getParameter('security.base_layout'),
                    'captcha' => $captcha->inline(),
                ]
            )
        );
    }
}
