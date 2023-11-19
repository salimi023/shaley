<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Home extends BaseController
{    
    // DB Models
    private $cache_model = false;    

    // Constructor
    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) 
    {
        parent::initController($request, $response, $logger);
        $this->cache_model = new \App\Models\CacheModel;        
    }    
    
    public function index(): string
    {
        $saved_offers = $this->cache_model->findAll();

        if(count($saved_offers) == 0) {        
        
            $curl = \Config\Services::curlrequest();

            // API call
            $offer_data_json = $curl->request('get', 'http://testapi.swisshalley.com/hotels/',
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'X-API-KEY' => 'b92189884ce200d55d403ccfe68f98f4'
                    ]
                ]    
            );

            $response_body = $offer_data_json->getBody();
            $response = json_decode($response_body, true);
            $hotels = $response['data']['hotels'];

            if(count($hotels) > 0) {
                foreach($hotels as $offer) {
                    $offer_data = [
                        'hotel_id' => $offer['hotel_id'],
                        'hotel_name' => $offer['hotel_name'],
                        'price' => $offer['price'],
                        'source' => $offer['source'],
                        'country_id' => $offer['country_id'],
                        'country' => $offer['country'],
                        'city_id' => $offer['city_id'],
                        'city' => $offer['city'],
                        'zip' => $offer['zip'],
                        'address' => $offer['address'],
                        'latitude' => $offer['latitude'],
                        'longitude' => $offer['longitude'],
                        'star' => $offer['star'],
                        'image' => $offer['image']
                    ];

                    $save_offer = $this->cache_model->insert($offer_data, false);
                }
            }                                   
        }                   
        
        return view('home');
    }
}
