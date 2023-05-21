<?php

namespace App\Controller;

use App\Entity\Expense;
use App\Repository\ExpenseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use OpenApi\Annotations as OA;
use AppBundle\Entity\Reward;

#use Nelmio\ApiDocBundle\Annotation\Model;





class ExpenseController extends AbstractController
{
   

    private $entityManager;
    private $expenseRepository;

    public function __construct(EntityManagerInterface $entityManager, ExpenseRepository $expenseRepository)
    {
        $this->entityManager = $entityManager;
        $this->expenseRepository = $expenseRepository;
    }

   /**
    * @Route("/api/expenses", name="expense_index", methods={"GET"})
   */
    public function index(): Response
    {
        error_log("Abadi is here");
        $expenses = $this->expenseRepository->findAll();

        return $this->json($expenses);
    }

    /**
     * @Route("api/expenses", name="expense_create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $description = $data['description'];
        $value = $data['value'];

        $expense = new Expense();
        $expense->setDescription($description);
        $expense->setValue($value);

        $this->entityManager->persist($expense);
        $this->entityManager->flush();

        return $this->json($expense, Response::HTTP_CREATED);
    }

    /**
     * @Route("/api/expenses/{id}", name="expense_show", methods={"GET"})
     */
    public function show(Expense $expense): Response
    {
        return $this->json($expense);
    }

    /**
     * @Route("/api/expenses/{id}", name="expense_update", methods={"PUT"})
     */
    public function update(Request $request, Expense $expense): Response
    {
        $data = json_decode($request->getContent(), true);

        $description = $data['description'] ?? $expense->getDescription();
        $value = $data['value'] ?? $expense->getValue();

        $expense->setDescription($description);
        $expense->setValue($value);

        $this->entityManager->flush();

        return $this->json($expense);
    }

    /**
     * @Route("/api/expenses/{id}", name="expense_delete", methods={"DELETE"})
     */
    public function delete(Expense $expense): Response
    {
        $this->entityManager->remove($expense);
        $this->entityManager->flush();

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }



}
