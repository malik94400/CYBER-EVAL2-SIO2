<?php

namespace App\Tests\Unit;

use App\Entity\Book;
use PHPUnit\Framework\TestCase;

class bookTest extends TestCase
{
    public function testSomething(): void
    {
        $book = new Book();

        $book->setTitle('Symfony pour les nuls');
        $book->setIsbn('978-1234567890');
        $publishedDate = new \DateTime('2023-01-01');
        $book->setPublishedAt($publishedDate);

        // Assertions
        $this->assertNull($book->getId());
        $this->assertEquals('Symfony pour les nuls', $book->getTitle());
        $this->assertEquals('978-1234567890', $book->getIsbn());
        $this->assertEquals($publishedDate, $book->getPublishedAt());
    }
}
