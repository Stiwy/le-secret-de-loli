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
            $card->title = $product[0]->getProduct()->getTitle() . ' ' . $product[0]->getSubTitle();
            $card->price = number_format($product[0]->getProduct()->getPrice()/100, 2);

            if (isset($sessionCard[$card->reference])) {
                $sessionCard[$card->reference]->quantity += $card->quantity;
            } else {
                $sessionCard[$card->reference] = $card;
            }

            $session->set('cardSession', $sessionCard);
        }
    }

    public static function update($session, $ref, $qte)
    {
        $sessionCard = $session->get('cardSession');

        try {
            if (array_key_exists($ref, $sessionCard) && is_numeric($qte)) {
                if ($qte > 0) {
                    $sessionCard[$ref]->quantity = $qte;
                    $session->set('cardSession', $sessionCard);
                }
            } else {
                throw new \Exception('URL invalide', 404);
            }
        }catch (\Exception $e) {
            echo $e->getMessage();
        }

    }

    public static function delete($session, $ref)
    {
        $sessionCard = $session->get('cardSession');

        try {
            if (array_key_exists($ref, $sessionCard)) {
                unset($sessionCard[$ref]);
                $session->set('cardSession', $sessionCard);
            } else {
                throw new \Exception('URL invalide', 404);
            }
        }catch (\Exception $e) {
            echo $e->getMessage();
        }

    }
}
