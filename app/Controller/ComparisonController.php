<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\CompareService;


class ComparisonController
{
    public function __construct()
    {
        $this->comparisonService = new CompareService();
    }

    public function index()
    {
        render('main');
    }

    public function compare()
    {
        $result =  $this->comparisonService->getComparison(trim($_POST['new']), trim($_POST['changed']));

        render('result', compact('result'));
    }
}