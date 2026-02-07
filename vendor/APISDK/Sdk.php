<?php
namespace APISDK;

use APISDK\ApiException;
use Firebase\JWT\JWT;
use Exception;

// const URL = "https://trpezaapi.lokalnipazar.rs";
/**
 * Site specific set of APIs
 *
 * @author arsenleontijevic
 * @since 30.09.2019
 */
class Sdk extends Api
{

    const DIR_UPLOADS = __DIR__ . "/../../images/";

    const DIR_USERS = "users";

    /*
     * const DIR_BAITS = "baits";
     * const DIR_USERS = "users";
     * const DIR_CATEGORIES = "categories";
     * const DIR_REPORTS = "reports";
     */

    /**
     * Instantiate Custom Api
     *
     * @param
     *            mixed \CI_DB_driver | Other Adapters $db
     * @param array $request
     * @param \Firebase\JWT\JWT $jwt
     */
    public function __construct($db, array $request, JWT $jwt = null)
    {
        parent::__construct($db, $request, $jwt);
    }

    /**
     * Analize request params
     *
     * @param array $request
     */
    protected function processRequest(array $request)
    {
        if (! isset($request['action'])) {
            throw new ApiException("The action param is required");
        }

        // Do not check acces_token for login and register actions
        if (! in_array($request['action'], [
            'login',
            'register',
            'forgotPassword',
            'forgotPasswordCheck'
        ])) {
            $at = null;
            if (! is_null($this->getBearerToken())) {
                $at = $this->getBearerToken();
            } elseif (isset($request['access_token'])) {
                $at = $request['access_token'];
            }
            if (is_null($at)) {
                throw new ApiException("The access_token param is required");
            }

            $decoded = $this->checkAccessToken($at);
            if ($decoded != self::TOKEN_VALID) {
                throw new ApiException("The access_token is not valid");
            }
        }

        if (method_exists($this, $request['action'])) {
            $action = $request['action'];
            
            $logFile = __DIR__ . '/api.log';
            $response = $this->$action();
            $this->logError(json_encode($request).json_encode($response), $logFile);
            $this->setResponse($response);
        } else {
            $this->setResponse($this->formatResponse("fail", "Unknown action", array()));
        }
    }

    /**
     *
     * @api {post}? crossCheck
     * @apiVersion 1.0.0
     * @apiSampleRequest https://uapi.intechopen.com
     * @apiName crossCheck
     * @apiGroup Users
     * @apiDescription crossCheck api will remove ineligible emails from the call list (Internal users, editors..)
     * @apiParam {String} action=crossCheck API Action.
     * @apiParam {Array} emails JSON array of author emails
     * @apiParam {String} book_id Manager book ID
     * @apiHeader {String} Authorization='Bearer <ACCESS_TOKEN>' access_token
     */

    /*
     * array_walk($products, function(&$a) {
     * if ($this->isFileExists(self::, $a["id"])) {
     * $a['image'] = $this->domain."/images/products/".$a["id"].".png?r=" . rand(0,100000);
     * }else{
     * $a['image'] = $this->domain."/images/logo.png";
     * }
     * $a["description"] = strip_tags($a["description"]);
     * $a["description"] = html_entity_decode($a["description"]);
     * });
     */

    // Preradi
    /*
     * private function isFileExists($dir, $id)
     * {
     * return file_exists(self::DIR_UPLOADS . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $id . ".png");
     * }
     */
    
    
    private function isFileExists($dir, $id)
    {
        return file_exists(self::DIR_UPLOADS . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $id . ".png");
    }
    
    private function isImageExists($id)
    {
        
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . "/images/users/";
        $upload_path = $upload_dir . $id . ".png";
        
        return file_exists($upload_path);
    }

    private function getProducts()
    {
        <?php

        $products = [
            [
                "id" => uniqid(),
                "name" => "Royal Canin Mini Adult",
                "description" => "Premium suva hrana za male pse.",
                "price" => 9.99,
                "imageURL" => "https://picsum.photos/300/300?1",
                "quantity" => 12
            ],
            [
                "id" => uniqid(),
                "name" => "Whiskas Chicken",
                "description" => "Hrana za mačke sa piletinom.",
                "price" => 4.49,
                "imageURL" => "https://picsum.photos/300/300?2",
                "quantity" => 2
            ],
            [
                "id" => uniqid(),
                "name" => "Pedigree Dentastix",
                "description" => "Dentalne poslastice za pse.",
                "price" => 3.29,
                "imageURL" => "https://picsum.photos/300/300?3",
                "quantity" => 20
            ],

            // ponovljeni blok kao u tvom primeru
            [
                "id" => uniqid(),
                "name" => "Royal Canin Mini Adult",
                "description" => "Premium suva hrana za male pse.",
                "price" => 9.99,
                "imageURL" => "https://picsum.photos/300/300?1",
                "quantity" => 12
            ],
            [
                "id" => uniqid(),
                "name" => "Whiskas Chicken",
                "description" => "Hrana za mačke sa piletinom.",
                "price" => 4.49,
                "imageURL" => "https://picsum.photos/300/300?2",
                "quantity" => 2
            ],
            [
                "id" => uniqid(),
                "name" => "Pedigree Dentastix",
                "description" => "Dentalne poslastice za pse.",
                "price" => 3.29,
                "imageURL" => "https://picsum.photos/300/300?3",
                "quantity" => 20
            ],

            [
                "id" => uniqid(),
                "name" => "Royal Canin Mini Adult",
                "description" => "Premium suva hrana za male pse.",
                "price" => 9.99,
                "imageURL" => "https://picsum.photos/300/300?1",
                "quantity" => 12
            ],
            [
                "id" => uniqid(),
                "name" => "Whiskas Chicken",
                "description" => "Hrana za mačke sa piletinom.",
                "price" => 4.49,
                "imageURL" => "https://picsum.photos/300/300?2",
                "quantity" => 2
            ],
            [
                "id" => uniqid(),
                "name" => "Pedigree Dentastix",
                "description" => "Dentalne poslastice za pse.",
                "price" => 3.29,
                "imageURL" => "https://picsum.photos/300/300?3",
                "quantity" => 20
            ]
        ];
        
        return $this->formatResponse(self::STATUS_SUCCESS, "", $products);
    }
}
