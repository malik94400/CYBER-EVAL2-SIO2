<?php

namespace App\Tests\Unit;

use App\Entity\Book;
use App\Entity\Client;
use App\Service\BorrowingManager;
use PHPUnit\Framework\TestCase;

class BorrowingManagerTest extends TestCase
{
    private BorrowingManager $borrowingManager;

    protected function setUp(): void
    {
        $this->borrowingManager = new BorrowingManager();
    }

    public function testClientWithFiveBorrowedBooksCannotBorrow(): void
    {
        $client = new Client();
        $client->setBorrowedBooksCount(5);

        $book = new Book();
        $book->setBorrowed(false);

        $this->assertFalse(
            $this->borrowingManager->canBorrowBook($client, $book),
            "Un client ayant déjà emprunté 5 livres ne peut pas en emprunter d'autres."
        );
    }

    public function testClientCanBorrowAvailableBook(): void
    {
        $client = new Client();
        $client->setBorrowedBooksCount(2);

        $book = new Book();
        $book->setBorrowed(false);

        $this->assertTrue(
            $this->borrowingManager->canBorrowBook($client, $book),
            "Un client peut emprunter un livre disponible."
        );
    }

    public function testClientCannotBorrowAlreadyBorrowedBook(): void
    {
        $client = new Client();
        $client->setBorrowedBooksCount(1);

        $book = new Book();
        $book->setBorrowed(true);

        $this->assertFalse(
            $this->borrowingManager->canBorrowBook($client, $book),
            "Un client ne peut pas emprunter un livre déjà emprunté par un autre client."
        );
    }
}
