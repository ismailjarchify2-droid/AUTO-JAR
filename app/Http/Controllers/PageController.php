<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        return view('pages.about');
    }

    public function faq(): View
    {
        $faqs = [
            [
                'q' => 'Livrez-vous partout au Maroc ?',
                'a' => 'Oui. Nous livrons à Casablanca, Rabat, Marrakech, Fès, Tanger, Agadir, Meknès et dans toutes les régions du Maroc. Les délais dépendent de la disponibilité de la pièce.',
            ],
            [
                'q' => 'Comment vérifier la compatibilité avec mon véhicule ?',
                'a' => 'Utilisez le sélecteur Marque → Modèle → Année sur la page d\'accueil, ou contactez-nous avec la référence VIN / immatriculation. Nos techniciens vérifient la compatibilité avant confirmation.',
            ],
            [
                'q' => 'Puis-je payer en ligne ?',
                'a' => 'Pour le moment, le paiement en ligne n\'est pas activé. Vous pouvez demander une pièce, recevoir un devis, puis régler en magasin, à la livraison ou via les moyens convenus avec notre équipe.',
            ],
            [
                'q' => 'Quels sont vos horaires ?',
                'a' => 'Nous sommes ouverts du lundi au samedi, de 09h00 à 19h00. Le dimanche sur rendez-vous pour les urgences.',
            ],
            [
                'q' => 'Comment commander via WhatsApp ?',
                'a' => 'Cliquez sur le bouton WhatsApp, envoyez la référence de la pièce, la marque/modèle/année de votre véhicule et votre ville. Nous répondons rapidement.',
            ],
            [
                'q' => 'Proposez-vous des pièces d\'origine et aftermarket ?',
                'a' => 'Oui. Nous proposons des pièces OEM et aftermarket de marques reconnues (Bosch, Valeo, NGK, Brembo, etc.) selon votre budget et vos besoins.',
            ],
            [
                'q' => 'Que faire si je ne trouve pas ma pièce ?',
                'a' => 'Utilisez le formulaire « Demande de pièce ». Joignez une photo et la référence si possible. Nous recherchons la pièce et vous recontactons.',
            ],
            [
                'q' => 'Les prix sont-ils en dirhams (DH) ?',
                'a' => 'Oui, tous les prix affichés sont en dirhams marocains (MAD / DH), TTC sauf mention contraire.',
            ],
        ];

        return view('pages.faq', compact('faqs'));
    }
}
