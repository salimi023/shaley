<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Home extends BaseController
{    
    // DB Models
    private $cache_offers_model = false;
    private $db = false;    

    // Constructor
    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) 
    {
        parent::initController($request, $response, $logger);
        $this->cache_offers_model = new \App\Models\CacheModel;
        $this->db = \Config\Database::connect('default');        
    }    
    
    public function index(): string
    {
        $result = false;
        $saved_offers = $this->cache_offers_model->findAll();
        $curl = \Config\Services::curlrequest();        

        if(count($saved_offers) == 0) {                           

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

                    $save_offer = $this->cache_offers_model->insert($offer_data, false);
                }

                $result = $this->pull_offers_data();
            }                                   
        } else {                                                            
            $result = $this->pull_offers_data();          
        }                
        
        // Adding image URL if not exists
        if($result) {                                    
            foreach($result as $index => $array) {
                if(empty($array['image'])) {
                    $hotel_id = $array['hotel_id'];                    
                    $find_image_sql = "SELECT offer_id, hotel_name, `image` FROM cache_offers WHERE hotel_id = $hotel_id AND `image` IS NOT NULL";
                    $image_url = $this->db->query($find_image_sql)->getResult('array');                                                                              
                    
                    // Checking the HTTP status code of image
                    if(!empty($image_url)) {
                        foreach($image_url as $url) {                            
                            $image_url_test = $curl->request('get', $url['image'], ['http_errors' => false]);
                            $http_response_code = $image_url_test->getStatusCode();                            

                            if($http_response_code == 200) {
                                $result[$index]['image'] = $url['image'];
                                break;
                            } 
                        }
                    }
                }
            }            

            $offers_data['offers'] = $result; 
        } else {
            $offers_data['offers'] = [];
        }                                         
        
        return view('home', $offers_data);        
    }

    /**
     * Pulling offers data from database 
     * @return array
     */    
    private function pull_offers_data() 
    {        
        $sql = "SELECT hotel_id, hotel_name, country, city, min(price) AS price, `image`, star FROM cache_offers 
        GROUP BY hotel_id";                                       
            
        return $this->db->query($sql)->getResult('array');
    }
}
