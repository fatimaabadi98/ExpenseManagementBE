<?php

namespace App\Controller;

use App\Entity\Expense;
use App\Repository\ExpenseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

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
        $expenses = $this->expenseRepository->findAll();

        return $this->json($expenses);
    }

    /**
     * @Route("/api/expenses", name="expense_create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        try {
            $data = json_decode($request->getContent(), true);

            $description = $data['description'] ?? null;
            $value = $data['value'] ?? null;

            if (empty($description) || empty($value)) {
                throw new BadRequestHttpException('Description and value are required.');
            }

            $expense = new Expense();
            $expense->setDescription($description);
            $expense->setValue($value);

            $this->entityManager->persist($expense);
            $this->entityManager->flush();

            return $this->json($expense, Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    /**
     * @Route("/api/expenses/{id}", name="expense_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        try {
            $expense = $this->expenseRepository->find($id);

            if (!$expense) {
                throw new NotFoundHttpException('Expense not found.');
            }

            return $this->json($expense);
        } catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    /**
     * @Route("/api/expenses/{id}", name="expense_update", methods={"PUT"})
     */
    public function update(Request $request, int $id): Response
    {
        try {
            $expense = $this->expenseRepository->find($id);

            if (!$expense) {
                throw new NotFoundHttpException('Expense not found.');
            }

            $data = json_decode($request->getContent(), true);

            $description = $data['description'] ?? $expense->getDescription();
            $value = $data['value'] ?? $expense->getValue();

            $expense->setDescription($description);
            $expense->setValue($value);

            $this->entityManager->flush();

            return $this->json($expense);
        } catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    /**
     * @Route("/api/expenses/{id}", name="expense_delete", methods={"DELETE"})
     */
    public function delete(int $id): Response
    {
        try {
            $expense = $this->expenseRepository->find($id);

            if (!$expense) {
                throw new NotFoundHttpException('Expense not found.');
            }

            $this->entityManager->remove($expense);
            $this->entityManager->flush();

            return $this->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    private function handleException(\Throwable $e): Response
    {
        $statusCode = $e instanceof NotFoundHttpException ? Response::HTTP_NOT_FOUND : Response::HTTP_BAD_REQUEST;

        return $this->json(['error' => $e->getMessage()], $statusCode);
    }
}
