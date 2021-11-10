<?php

namespace App\Partials;

class AddCard
{

    public static function index($addCard, $session, $product, $request)
    {
        $addCard->handleRequest($request);

        $sessionCard = $session->get('cardSession');

        if ($addCard->isSubmitted() && $addCard->isValid()) {
            $card = $addCard->getData();
            $card->reference = $product[0]->getReference();

            if (isset($sessionCard[$card->reference])) {
                $sessionCard[$card->reference]->quantity += $card->quantity;
            } else {
                $sessionCard[$card->reference] = $card;
            }

            $session->set('cardSession', $sessionCard);
        }
    }
}
