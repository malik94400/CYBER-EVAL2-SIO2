<?php

namespace App\Tests\Unit;

use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BookValidationTest extends KernelTestCase
{
    public function testInvalidBookWithoutTitle(): void
    {
        $book = new Book();
        $book->setIsbn('978-1234567890');
        $book->setPublishedAt(new \DateTime('2023-01-01')); // Assurez-vous que cette valeur est correcte

        $errors = $this->validate($book);

        // Vérifiez toutes les erreurs retournées
        foreach ($errors as $error) {
            echo $error->getMessage() . PHP_EOL;
        }

        $this->assertCount(1, $errors); // Vérifiez que seul le titre manque
        $this->assertEquals('Le titre ne peut pas être vide.', $errors[0]->getMessage());
    }

    public function testInvalidBookWithoutIsbn(): void
    {
        $book = new Book();
        $book->setTitle('Symfony for Beginners');
        $book->setPublishedAt(new \DateTime('2023-01-01'));

        $errors = $this->validate($book);

        // Vérifiez toutes les erreurs retournées
        foreach ($errors as $error) {
            echo $error->getMessage() . PHP_EOL;
        }

        $this->assertCount(1, $errors); // Vérifiez que seul l'ISBN manque
        $this->assertEquals('L\'ISBN ne peut pas être vide.', $errors[0]->getMessage());
    }

    public function testInvalidBookWithoutPublishedAt(): void
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
