<?php

require_once(__DIR__ . '../../../../configurations/connection.php');
require_once(__DIR__ . '../../../services/homeService.php'); // Mengimpor HomeService

class HomeController
{
    private $homeService;

    public function __construct()
    {
        $this->homeService = new HomeService();
    }

    public function handleGetSaldo()
    {
        $response = $this->homeService->getSaldo();
        return $response;
    }
    public function handleGetAllLogsSaldo()
    {
        $response = $this->homeService->getAllLogsSaldo();
        return $response;
    }

}

