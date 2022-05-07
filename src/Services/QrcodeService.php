<?php

namespace App\Services;

use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCode\Color\Color;


class QrcodeService
{

    /**
     * @var BuilderInterface
     */


    protected $Builder;

    public function __construct(BuilderInterface $Builder)
    {
        $this->builder = $Builder;
    }

    public function qrcode($query)
    {
        $objDateTime = new \DateTime('NOW');
        $dateString = $objDateTime->format('d-m-y H:i:s');
        $url = 'https://www.google.com/search?q';
        $result = $this->builder
            ->data($url . $query)
            ->size(400)
            ->encoding(new Encoding('UTF-8'))
            ->labelText($dateString)
            ->backgroundColor(new Color(186, 0, 0))
            ->build();


        $namePNG = uniqid('', '') . '.png';

        $result->saveToFile((\dirname(__DIR__, 2) . '/public/qr-code/' . $namePNG));


        return $result->getDataUri();
    }
}
