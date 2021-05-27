<?php

namespace App\Http\Controller;

use App\Domain\MainService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    public function __construct(public MainService $mainService){}
}
