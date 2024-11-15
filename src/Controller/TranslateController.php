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
        // Récupérer la langue à partir de la requête (par défaut 'fr')
        $lang = $request->get('lang', 'fr');

        // Sauvegarder la langue dans la session
        $session->set('lang', $lang);

        // Rediriger vers la page précédente ou vers la home
        return $this->redirect($request->headers->get('referer') ?: $this->generateUrl('home'));
    }
}
