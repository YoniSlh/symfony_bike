<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TranslateController extends AbstractController
{
    #[Route('/translate', name: 'translate', methods: ['GET'])]
    public function changeLanguage(Request $request, SessionInterface $session): RedirectResponse
    {
        $lang = $request->get('lang', 'fr');

        $session->set('lang', $lang);

        return $this->redirect($request->headers->get('referer') ?: $this->generateUrl('home'));
    }
}
