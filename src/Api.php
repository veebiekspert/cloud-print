<?php
namespace Veebiekspert\CloudPrint;

use GuzzleHttp\Client;

/**
 * E-liides cloud printer API client
 */
class Api
{

    /**
     * Api key
     *
     * @var string
     */
    protected $apiKey = '';

    /**
     * Api url
     *
     * @var string
     */
    protected $url = 'https://www.e-liides.ee/api/';

    /**
     * Prinxit constructor.
     * @param $apiKey
     */
    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    /**
     * Get List of Printers
     *
     * @return array
     */
    public function getPrinters() {
        $result = $this->sendRequest('cloud-print', 'get-printers');
        if (isset($result['status']) && isset($result['data']) && $result['status'] == 'ok') {
            return $result['data'];
        }
        return [];
    }

    /**
     * Add job
     *
     * @param $pdfSource
     * @param $printerId
     * @return mixed
     */
    public function addJob($pdfSource, $printerId)
    {
        $result = $this->sendRequest('cloud-print', 'add-job', array(
            'file' => $pdfSource,
            'printer_id' => $printerId,
        ));
        if (isset($result['status']) && isset($result['data']) && $result['status'] == 'ok') {
            return $result['data'];
        }
        throw new \Exception($result['error']);
    }

    /**
     * Send request to Cloud Printer API
     *
     * @param string $type
     * @param string $method
     * @param array $filter
     * @return mixed
     */
    protected function sendRequest($type, $method, $filter = array())
    {
        $filter['api_key'] = $this->apiKey;

        $client = new Client();
        $response = $client->request('POST', $this->url . $type . '/' . $method, [
            'verify' => false,
            'form_params' => $filter,
        ]);
        return json_decode($response->getBody(), true);
    }
}