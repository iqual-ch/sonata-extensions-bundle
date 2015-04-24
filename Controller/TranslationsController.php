<?php

namespace SonataExtensionsBundle\Controller;

use Exception;
use ReflectionClass;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\Translator;

class TranslationsController extends Controller
{

    /**
     * @Route("/locale/messages.json", methods={"GET"}, name="se_frontend_translations")
     */
    public function jsAction()
    {
        /* @var $translator Translator */
        $translator = $this->get('translator');
        $content = 'var _TRANSLATIONS = ' . json_encode($translator->getMessages()['javascript']);
        
        return new Response($content, 200, array(
            'Content-Type' => 'application/javascript'
        ));
    }
}
