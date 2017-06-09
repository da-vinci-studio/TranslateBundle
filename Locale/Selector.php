<?php

namespace Dvs\Bundle\Core\TranslateBundle\Locale;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Responsible for Locale selection.
 */
class Selector
{
    /**
     * @var array
     */
    protected $acceptableLocales;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @param TranslatorInterface $translator
     * @param array               $acceptableLocales
     */
    public function __construct(
        TranslatorInterface $translator,
        array $acceptableLocales
    ) {
        $this->acceptableLocales = $acceptableLocales;
        $this->translator = $translator;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $preferredLocale = $request->getPreferredLanguage($this->acceptableLocales);

        $this->translator->setLocale($preferredLocale);
        $request->setLocale($preferredLocale);
    }
}
