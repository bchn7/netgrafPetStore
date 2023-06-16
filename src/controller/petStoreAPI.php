<?
// Klasa do zarządzania komunikacja z API
class petStoreAPI 
{
    private $apiUrl;
    
    /**
     * Summary of __construct
     * @param mixed $apiUrl
     */
    public function __construct($apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    // Metoda która wykonuje żądania HTTP
    /**
     * Summary of makeRequest
     * @param mixed $method
     * @param mixed $url
     * @param mixed $data
     * @return mixed
     */
    private function makeRequest($method, $url, $data = [])
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        if($method == 'POST'){
            curl_setopt($curl, CURLOPT_POST,true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        } elseif($method == 'PUT'){
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_decode($data));
        } elseif($method == 'DELETE'){
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER,
        [
            'Content-Type: application/json',
            'Accept: application/json',
        ]);

        $response = curl_exec($curl);
        $statusCode = curl_getinfo($curl,CURLINFO_HTTP_CODE);

        if($statusCode >= 400){
            $error = json_decode($response, true);
            $errorMessage = $error['message'] ?? 'Unknown error';

        } else {
            return json_decode($response, true);
        }

        curl_close($curl);
    }

    // Metoda do pobrania wszystkich elementów z /pet
    /**
     * Summary of getAllPets
     * @return mixed
     */
    public function getAllPets() 
    {
        return $this->makeRequest('GET', $this->apiUrl.'/pet');    
    }

    //Metoda do dodawania nowego elementu
    /**
     * Summary of addPet
     * @param mixed $name
     * @param mixed $category
     * @param mixed $status
     * @return mixed
     */
    public function addPet($name, $category, $status)
    {
        $petData = [
            'name' => $name,
            'category' => [
                'name' => $category
            ],
            'status' => $status
        ];

        return $this->makeRequest('POST', $this->apiUrl.'/pet', $petData);
    }

        // Metoda do usuwania elementu
        /**
         * Summary of deletePet
         * @param mixed $petId
         * @return mixed
         */
        public function deletePet($petId)
        {
            return $this->makeRequest('DELETE', $this->apiUrl.'/pet/'.$petId);
        }
}
