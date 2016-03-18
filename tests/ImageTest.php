<?php

namespace Rokka\Client\Tests;

use Rokka\Client\Factory;
use Rokka\Client\Image;

class ImageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public function dataProviderGetSourceImageUri()
    {
        $organization = 'testorg';
        $apiKey = 'apiKey';
        $apiSecret = 'apiSecret';

        $clientStandard = Factory::getImageClient($organization, $apiKey, $apiSecret);
        $clientNewBaseUrl = Factory::getImageClient($organization, $apiKey, $apiSecret, 'http://api.rokka.local:8888');

        return [
            // Standard Rokka.io BaseUri
            ['https://testorg.rokka.io/stack-name/HASH109283.jpg', $clientStandard, 'HASH109283', 'stack-name', 'jpg'],
            ['https://testorg.rokka.io/stack-name/HASH109283.png', $clientStandard, 'HASH109283', 'stack-name', 'png'],
            ['https://testorg.rokka.io/stack-name/HASH109283.gif', $clientStandard, 'HASH109283', 'stack-name', 'gif'],
            ['https://testorg.rokka.io/stack-name/HASH109283.xxx', $clientStandard, 'HASH109283', 'stack-name', 'xxx'],
            ['https://testorg.rokka.io/stack-name/HASH109283/seoname.xxx', $clientStandard, 'HASH109283', 'stack-name', 'xxx', 'seoname'],
            ['https://new-org.rokka.io/stack-name/HASH109283.jpg', $clientStandard, 'HASH109283', 'stack-name', 'jpg', null, 'new-org'],
            ['https://new-org.rokka.io/stack-name/HASH109283/seoname.jpg', $clientStandard, 'HASH109283', 'stack-name', 'jpg', 'seoname', 'new-org'],
            // Edited BaseUrl of Rokka.io server
            ['http://testorg.rokka.local:8888/stack-name/HASH109283.jpg', $clientNewBaseUrl, 'HASH109283', 'stack-name', 'jpg'],
        ];
    }

    /**
     * @dataProvider dataProviderGetSourceImageUri
     *
     * @param                     $expected
     * @param \Rokka\Client\Image $client
     * @param                     $hash
     * @param                     $stack
     * @param                     $format
     * @param                     $name
     * @param string              $organization
     */
    public function testGetSourceImageUri($expected, Image $client, $hash, $stack, $format, $name = null, $organization = null)
    {
        $uri = $client->getSourceImageUri($hash, $stack, $format, $name, $organization);
        $this->assertEquals($expected, $uri->__toString());
    }
}
