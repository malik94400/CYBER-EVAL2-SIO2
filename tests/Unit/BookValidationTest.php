<?php

namespace App\Tests\Unit;

use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BookValidationTest extends KernelTestCase
{
    public function testNoTitle(): void
    {
        $book = new Book();
        $book->setIsbn('978-1234567890');
        $book->setPublishedAt(new \DateTime('2023-01-01'));

        $errors = $this->validate($book);

        foreach ($errors as $error) {
            echo $error->getMessage() . PHP_EOL;
        }

        $this->assertCount(1, $errors);
        $this->assertEquals('Le titre ne peut pas être vide.', $errors[0]->getMessage());
    }

    public function testNoIsbn(): void
    {
        $book = new Book();
        $book->setTitle('Symfony for Beginners');
        $book->setPublishedAt(new \DateTime('2023-01-01'));

        $errors = $this->validate($book);

        foreach ($errors as $error) {
            echo $error->getMessage() . PHP_EOL;
        }

        $this->assertCount(1, $errors);
        $this->assertEquals('L\'ISBN ne peut pas être vide.', $errors[0]->getMessage());
    }

    public function testInvalideIsbn(): void
    {
        $book = new Book();
        $book->setTitle('Some Book Title');
        $book->setIsbn('1234');
        $book->setPublishedAt(new \DateTime());

        $errors = $this->validate($book);

        $this->assertCount(1, $errors);
        $this->assertEquals('Le numéro ISBN doit contenir exactement 14 caractères.', $errors[0]->getMessage());

        $book->setIsbn('123456789012345');
        $errors = $this->validate($book);

        $this->assertCount(1, $errors);
        $this->assertEquals('Le numéro ISBN doit contenir exactement 14 caractères.', $errors[0]->getMessage());

        $book->setIsbn('12345678901234');

        $errors = $this->validate($book);

        $this->assertCount(0, $errors);
    }

    public function testNoPublishedAt(): void
    {
        $book = new Book();
        $book->setTitle('Symfony for Beginners');
        $book->setIsbn('978-1234567890');

        $errors = $this->validate($book);

        $this->assertCount(1, $errors);
        $this->assertEquals('La date de publication ne peut pas être vide.', $errors[0]->getMessage());
    }

    public function testValidBook(): void
    {
        $book = new Book();
        $book->setTitle('Symfony for Beginners');
        $book->setIsbn('978-1234567890');
        $book->setPublishedAt(new \DateTime('2023-01-01'));

        $errors = $this->validate($book);

        $this->assertCount(0, $errors);
    }

    private function validate($entity)
    {
        self::bootKernel();
        $validator = self::getContainer()->get('validator');

        return $validator->validate($entity);
    }
}
