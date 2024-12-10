<?php

namespace App\Tests\Unit;

use App\Entity\Author;
use App\Entity\Book;
use PHPUnit\Framework\TestCase;

class AuthorTest extends TestCase
{
    public function testAjtLivreAut(): void
    {
        $author = new Author();
        $author->setName('J.K. Rowling');

        $book1 = new Book();
        $book1->setTitle('Harry Potter and the Philosopher\'s Stone')
            ->setIsbn('978-1234567890')
            ->setPublishedAt(new \DateTime('1997-06-26'));

        $book2 = new Book();
        $book2->setTitle('Harry Potter and the Chamber of Secrets')
            ->setIsbn('978-1234567891')
            ->setPublishedAt(new \DateTime('1997-06-26'));

        $author->addBook($book1);
        $author->addBook($book2);

        $this->assertCount(2, $author->getBooks());
        $this->assertSame($author, $book1->getAuthor());
        $this->assertSame($author, $book2->getAuthor());
    }

    public function testSuppLivreAuth(): void
    {
        $author = new Author();
        $author->setName('J.K. Rowling');

        $book = new Book();
        $book->setTitle('Harry Potter and the Philosopher\'s Stone')
            ->setIsbn('978-1234567890')
            ->setPublishedAt(new \DateTime('1997-06-26'));

        $author->addBook($book);
        $this->assertCount(1, $author->getBooks());

        $author->removeBook($book);
        $this->assertCount(0, $author->getBooks());
        $this->assertNull($book->getAuthor());
    }
}
