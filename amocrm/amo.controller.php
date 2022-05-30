<?php
class amoCrmController {
    const REDIRECT = "https://vodniy.rusartschool.ru/";
    const SUBDOMAIN = "rusartschool";
    const SECRET = "qo3HmZt0USbQo2KLvlDS2ZKwozvQclDxz2xI3ttMBuL5rtm6zaKbQk5NWrFzCZOH";
    const CLIENT = "de780b7d-92a1-481c-bd83-fb0409dfbf8a";

    protected function getNewTokens() {
        $link = 'https://' . self::SUBDOMAIN . '.amocrm.ru/oauth2/access_token';

        $data = [
            'client_id' => self::CLIENT,
            'client_secret' => self::SECRET,
            'grant_type' => 'authorization_code',
            'code' => 'def50200218eacd6f1bb260aa14406835a2548f649fdbe2abac2f5edd07c95ce54a29e745b8b9515b9302b8dd00e1bfac5d6407a09a43ac4d444224a0c2ee2ede0f006bd4e292223b869f10558643ae9e5ef38ba2f2795b91cd0b1002481bb0f951b93b65fc973dc673451ff715ba696c82f5a84679af990f94d54ada81f2019e88dac00e99f0cea93eb8e0440c8d3f7658e1db765aff3f5b376ffc1c3137f9b1d3c27a13a4d4ca1270014fc5623085d3008fb649e4a6f3625075be0f3b7c2f5805c8d1ca71697a8395846473973c2675515043aeb61bf546e929281538c5fcaee45b6a89bb6e3fe50854ecd33d6de843fa27c71a07be0a0d6b39a7a87a695a86797490bdd08126fc694efd032dce7df2240242e5388fae8bcf5609c0f1942ac0bc4dad739145e51b7c55e5a3c12e1ce15b79e22890f20ba2239d11652bdf274b1d913999efa3afd74371a4a919446fadc74409be034c7d26d19c662d347a8acebfaec25f5fd66e6a60dcbf1171ab92b40212000e2e9b074dde6d0c6bc38df676046b552c4bb479e160a7b2d5810bf9bfcbffdc948a52e66248ceefa20c8894e51aeda4b9c0aee0f5094f1c15895890440272d01e4bc79223d92f6571a4bc424e36c92d8f8b2fba7ef7e',
            'redirect_uri' => self::REDIRECT,
        ];

        $curl = curl_init();
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
        curl_setopt($curl,CURLOPT_URL, $link);
        curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
        curl_setopt($curl,CURLOPT_HEADER, false);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $code = (int)$code;
        $errors = [
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable',
        ];

        try {
            if ($code < 200 || $code > 204) {
                throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
            }
        } catch(\Exception $e) {
            die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
        }

        $response = json_decode($out, true);

        $access_token = $response['access_token']; //Access токен
        $refresh_token = $response['refresh_token']; //Refresh токен
        $token_type = $response['token_type']; //Тип токена
        $expires_in = $response['expires_in']; //Через сколько действие токена истекает

        $filename = __DIR__ . "/config.conf";
        $file = fopen($filename, 'w+');
        fwrite($file, $access_token.PHP_EOL);
        fwrite($file, $refresh_token.PHP_EOL);
        fwrite($file, time() + $expires_in);
        fclose($file);
    }

    protected function getTokensFromFile() {
        $filename = __DIR__ . "/config.conf";
        $handle = fopen($filename, "r");
        $contents = fread($handle, filesize($filename));
        fclose($handle);
        return explode(PHP_EOL, $contents);
    }

    protected function checkAccessToAmoCRM() {
        $contents = $this->getTokensFromFile();

        $access_token = $contents[0];
        $time = (int)$contents[2];

        if(time() >= $time) {
            $newToken = $this->refactorTokens();
            $return = $newToken;
        } else {
            $return = $access_token;
        }

        return $return;
    }

    protected function refactorTokens() {
        $contents = $this->getTokensFromFile();

        $link = 'https://' . self::SUBDOMAIN . '.amocrm.ru/oauth2/access_token';
        $data = [
            'client_id' => self::CLIENT,
            'client_secret' => self::SECRET,
            'grant_type' => 'refresh_token',
            'refresh_token' => $contents[1],
            'redirect_uri' => self::REDIRECT,
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $code = (int)$code;

        try {
            if ($code < 200 || $code > 204) {
                throw new Exception("Error");
            }
        } catch (\Exception $e) {
            die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
        }

        $response = json_decode($out, true);

        $access_token = $response['access_token']; //Access токен
        $refresh_token = $response['refresh_token']; //Refresh токен
        $expires_in = $response['expires_in']; //expires_in

        $filename = __DIR__ . "/config.conf";
        $file = fopen($filename, 'w+');
        fwrite($file, $access_token.PHP_EOL);
        fwrite($file, $refresh_token.PHP_EOL);
        fwrite($file, time() + $expires_in);
        fclose($file);

        return $access_token;
    }

    protected function postCurl($path, $data) {
        $refreshToken = $this->checkAccessToAmoCRM();
        $link = "https://" . self::SUBDOMAIN . ".amocrm.ru" . $path;

        $headers = [
            'Authorization: Bearer ' . $refreshToken,
            'Content-Type: application/json'
        ];

        $curl = curl_init();
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
        curl_setopt($curl,CURLOPT_URL, $link);
        curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl,CURLOPT_HEADER, false);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
        $out = curl_exec($curl);
        curl_close($curl);

        return json_decode($out);
    }

    protected function getCurl($path) {
        $refreshToken = $this->checkAccessToAmoCRM();
        $link = "https://" . self::SUBDOMAIN . ".amocrm.ru" . $path;

        $headers = [
            'Authorization: Bearer ' . $refreshToken,
            'Content-Type: application/json'
        ];

        $curl = curl_init();
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
        curl_setopt($curl,CURLOPT_URL, $link);
        curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl,CURLOPT_HEADER, false);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
        $out = curl_exec($curl);
        curl_close($curl);

        return json_decode($out);
    }

    public function createLead($data) {
        return $this->postCurl("/api/v4/leads", [$data]);
    }

    public function LinkForLead($leadID, $contactID) {
        $data = [
            [
                'to_entity_id' => $contactID,
                'to_entity_type' => 'contacts',
            ],
        ];

        return $this->postCurl("/api/v4/leads/".$leadID."/link", $data);
    }
    
    public function setCommentForm($leadID, $comment) {

        $send = [
            'add' => [
                [
                    'element_id' => $leadID,
                    'element_type' => 2,
                    'text' => $comment,
                    'note_type' => '4',
                ],
            ],
        ];

        return $this->postCurl("/api/v2/notes", $send);
    }

    public function createUser($data) {
        return $this->postCurl("/api/v4/contacts", $data);
    }

    public function searchUser($user) {

        $thisUser = $this->getCurl("/api/v4/contacts?query=" . $user["phone"]);
        if(
            isset($thisUser->_embedded) &&
            isset($thisUser->_embedded->contacts) &&
            isset($thisUser->_embedded->contacts[0]) &&
            isset($thisUser->_embedded->contacts[0]->id) &&
            $thisUser->_embedded->contacts[0]->id > 0
        ) {
            return $thisUser->_embedded->contacts[0]->id;
        } else {
            $data = [
                'name' => $user["name"],
                'custom_fields_values' => [
                    [
                        "field_id" => 710783,
                        "values" => [
                            [
                                "value" => $user["phone"]
                            ]
                        ]
                    ],
                    [
                        "field_id" => 710785,
                        "values" => [
                            [
                                "value" => $user["email"]
                            ]
                        ]
                    ]
                ]
            ];

            $newUser = $this->createUser([$data]);
            if(
                isset($newUser->_embedded) &&
                isset($newUser->_embedded->contacts) &&
                isset($newUser->_embedded->contacts[0]) &&
                isset($newUser->_embedded->contacts[0]->id) &&
                $newUser->_embedded->contacts[0]->id > 0
            ) {
                return $newUser->_embedded->contacts[0]->id;
            } else {
                return $newUser;
            }
        }
    }

    public function createLeadForm($data) {
        return $this->postCurl("/api/v4/leads", [$data]);
    }

    public function backCall($name, $data) {
        $_user = [
            "name" => $data["your-name"],
            "phone" => $data["your-tel"],
            "email" => ""
        ];
        $user = $this->searchUser($_user);
        if($user > 0) {

            $result = [
                "name" => $name,
                "pipeline_id" => 3868150,
                "status_id" => 37796992,
                "_embedded" => [
                    "tags" => [
                        [
                            "id" => 183057
                        ]
                    ]
                ]
            ];

            $newLead = $this->createLeadForm($result);

            if(
                isset($newLead->_embedded) &&
                isset($newLead->_embedded->leads[0]) &&
                isset($newLead->_embedded->leads[0]->id) &&
                $newLead->_embedded->leads[0]->id > 0
            ) {
                $leadID = $newLead->_embedded->leads[0]->id;
                $this->LinkForLead($leadID, $user);
                $this->setCommentForm($leadID, "Источник трафика: " . $data["handl_ref"]);
            }
        }
    }



    public function helpInSelection($name, $data) {
        $_user = [
            "name" => $data["your-name"],
            "phone" => $data["your-tel"],
            "email" => ""
        ];
        $user = $this->searchUser($_user);
        if($user > 0) {

            $result = [
                "name" => $name,
                "pipeline_id" => 3868150,
                "status_id" => 37796992,
                "_embedded" => [
                    "tags" => [
                        [
                            "id" => 183623
                        ]
                    ]
                ]
            ];

            $newLead = $this->createLeadForm($result);

            if(
                isset($newLead->_embedded) &&
                isset($newLead->_embedded->leads[0]) &&
                isset($newLead->_embedded->leads[0]->id) &&
                $newLead->_embedded->leads[0]->id > 0
            ) {
                $leadID = $newLead->_embedded->leads[0]->id;
                $this->LinkForLead($leadID, $user);
                $this->setCommentForm($leadID, "Источник трафика: " . $data["handl_ref"]);
            }
        }
    }
}