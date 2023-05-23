<?php
// src/Controller/CategoryController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends AbstractController
{
    #[Route('/category/', name: 'category_index')]
        public function index (CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findBy([], ['name' => 'ASC']);

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
         ]);
    }

    #[Route('/category/{categoryName}', name: 'category_show')]
    public function show(string $categoryName, CategoryRepository $categoryRepository, ProgramRepository $programRepository): Response
    {
        // Récupérer la catégorie par son nom
        $category = $categoryRepository->findOneBy(['name' => $categoryName]);
    
        // Vérifier si la catégorie existe
        if (!$category) {
            throw new NotFoundHttpException('La catégorie n\'existe pas.');
        }
    
        // Récupérer les séries appartenant à cette catégorie
        $programs = $programRepository->findBy(['category' => $category], ['id' => 'ASC'], 3);
    
        return $this->render('category/show.html.twig', [
            'category' => $category,
            'programs' => $programs,
        ]);
    }
}
