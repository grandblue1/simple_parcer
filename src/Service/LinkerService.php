<?php

namespace Src\Service;
use DOMDocument,DOMXPath;
use Src\Model\Linker;
use Src\Model\Subscription;

class LinkerService
{
    /**
     * Parses the price and currency from a given product link.
     *
     * @param string $link The product link.
     * @return array Associative array with 'price' and 'currency' keys.
     */
    public static function parsePrice($link)
    {
        $html = file_get_contents($link);
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();
        $xpath = new DOMXPath($dom);

        $price = null;
        $currency = null;

        switch(true){
            case strpos($link, 'rozetka.com.ua') !== false:
                $priceNode = $xpath->query('//p[@class="product-price__big"]')->item(0);

                if (!$priceNode) {
                    $priceNode = $xpath->query('//p[@class="product-price__big product-price__big-color-red"]')->item(0);
                }

                if ($priceNode) {
                    $priceContent = $priceNode->textContent;
                    $price = intval(trim($priceContent));
                    $currency = '';
                }

                break;
            case strpos($link,'allo.ua') !== false:
                $priceNode = $xpath->query('//meta[@itemprop="price"]')->item(0);
                $currencyNode = $xpath->query('//meta[@itemprop="priceCurrency"]')->item(0);
                if ($priceNode) {
                    $price = intval(trim($priceNode->getAttribute('content')));
                }
            
                if ($currencyNode) {
                    $currency = trim($currencyNode->getAttribute('content'));
                }
                break;
            case strpos($link, 'olx.ua') !== false:
                $priceNode = $xpath->query('//div[@data-testid="ad-price-container"]//h3')->item(0);
                if ($priceNode) {
                    $val = explode(' ',$priceNode->textContent);
                    $price = intval(trim($val[0].$val[1]));
                    $currency = $val[2];
                }
                break;
        }
        return [
            'price' => $price,
            'currency' => $currency,
        ];
    }
    /**
     * Tracks prices for all registered links, notifies subscribers, and updates prices.
     */
    public static function trackPrices(){

        $links = Linker::getAllLinks();

        foreach($links as $link){

            $currentPrice = self::parsePrice($link);

            if($currentPrice['price'] !== null && $link->getPrice() != $currentPrice['price']){
                $subscribers = Subscription::getSubscriptionByLinkerID($link->getId());
                $price = $currentPrice['price'].' '.$currentPrice['currency'];

                foreach($subscribers as $sub){
                    MailService::sendMail($sub['email'],$link->getLink(),$price);
                }

                $link->setPrice($currentPrice['price']);
                $link->update();
            }
        }

    }
}