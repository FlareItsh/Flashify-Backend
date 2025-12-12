<?php

namespace Database\Seeders;

use App\Models\Flashcard;
use App\Models\Collection;
use Illuminate\Database\Seeder;

class FlashcardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collections = Collection::all();

        $flashcardsData = [
            // JavaScript Flashcards
            'JavaScript Fundamentals' => [
                [
                    'front' => 'What is a closure in JavaScript?',
                    'back' => 'A closure is a function that has access to variables in its outer scope, even after the outer function has returned.',
                    'hint' => 'Think about function scope and lexical environment',
                    'explaination' => 'Closures are created when a function is defined inside another function, allowing the inner function to access the outer function\'s variables.',
                ],
                [
                    'front' => 'What is the difference between let and var?',
                    'back' => 'let has block scope while var has function scope. let cannot be redeclared in the same scope.',
                    'hint' => 'Consider scoping rules',
                    'explaination' => 'var is function-scoped and can be redeclared, while let is block-scoped and cannot be redeclared in the same scope.',
                ],
                [
                    'front' => 'What is event bubbling?',
                    'back' => 'Event bubbling is when an event propagates from the target element up through its ancestors in the DOM tree.',
                    'hint' => 'Think about DOM event flow',
                    'explaination' => 'When an event occurs on an element, it first runs handlers on that element, then on its parent, and continues up to the root.',
                ],
            ],
            // PHP Laravel Flashcards
            'PHP Laravel' => [
                [
                    'front' => 'What is Eloquent ORM?',
                    'back' => 'Eloquent is Laravel\'s built-in ORM for database interactions using an Active Record pattern.',
                    'hint' => 'Object-Relational Mapping',
                    'explaination' => 'Eloquent provides a simple ActiveRecord implementation for working with your database. Each database table has a corresponding Model.',
                ],
                [
                    'front' => 'What is middleware in Laravel?',
                    'back' => 'Middleware provides a mechanism for filtering HTTP requests entering your application.',
                    'hint' => 'Request filtering',
                    'explaination' => 'Middleware can perform tasks like authentication, logging, or modifying requests before they reach your application logic.',
                ],
                [
                    'front' => 'What is Service Container?',
                    'back' => 'A powerful tool for managing class dependencies and performing dependency injection.',
                    'hint' => 'Dependency injection',
                    'explaination' => 'The service container is a central place to resolve and manage class dependencies throughout your application.',
                ],
            ],
            // Database Design Flashcards
            'Database Design' => [
                [
                    'front' => 'What is normalization?',
                    'back' => 'The process of organizing data to reduce redundancy and improve data integrity.',
                    'hint' => 'Data organization',
                    'explaination' => 'Normalization involves dividing large tables into smaller ones and defining relationships to minimize redundancy.',
                ],
                [
                    'front' => 'What is a foreign key?',
                    'back' => 'A column that creates a relationship between two tables by referencing the primary key of another table.',
                    'hint' => 'Table relationships',
                    'explaination' => 'Foreign keys enforce referential integrity between tables and are used to establish relationships.',
                ],
                [
                    'front' => 'What is an index?',
                    'back' => 'A database structure that improves the speed of data retrieval operations on a table.',
                    'hint' => 'Performance optimization',
                    'explaination' => 'Indexes work like a book\'s index, allowing the database to find data without scanning the entire table.',
                ],
            ],
            // React Flashcards
            'React Basics' => [
                [
                    'front' => 'What are React Hooks?',
                    'back' => 'Functions that let you use state and other React features in functional components.',
                    'hint' => 'useState, useEffect',
                    'explaination' => 'Hooks like useState and useEffect allow functional components to have state and side effects without using class components.',
                ],
                [
                    'front' => 'What is JSX?',
                    'back' => 'A syntax extension for JavaScript that looks similar to XML/HTML and is used in React.',
                    'hint' => 'JavaScript XML',
                    'explaination' => 'JSX makes it easier to write and add HTML in React by allowing you to write HTML-like code in JavaScript.',
                ],
                [
                    'front' => 'What is Virtual DOM?',
                    'back' => 'A lightweight copy of the actual DOM kept in memory and synced with the real DOM.',
                    'hint' => 'Performance optimization',
                    'explaination' => 'React uses Virtual DOM to efficiently update only the parts of the page that changed, improving performance.',
                ],
            ],
            // Python Programming Flashcards
            'Python Programming' => [
                [
                    'front' => 'What is a list comprehension?',
                    'back' => 'A concise way to create lists based on existing lists or iterables.',
                    'hint' => '[x for x in range(10)]',
                    'explaination' => 'List comprehensions provide a more readable and compact way to create lists compared to traditional for loops.',
                ],
                [
                    'front' => 'What is a decorator?',
                    'back' => 'A function that modifies or enhances another function without changing its source code.',
                    'hint' => '@decorator syntax',
                    'explaination' => 'Decorators use the @decorator_name syntax and are commonly used for logging, timing, or authentication.',
                ],
            ],
        ];

        foreach ($collections as $collection) {
            // Find matching flashcards for this collection
            foreach ($flashcardsData as $collectionName => $flashcards) {
                if (strpos($collection->name, $collectionName) !== false) {
                    foreach ($flashcards as $flashcard) {
                        Flashcard::create([
                            'collection_id' => $collection->collection_id,
                            'front' => $flashcard['front'],
                            'back' => $flashcard['back'],
                            'hint' => $flashcard['hint'] ?? null,
                            'explaination' => $flashcard['explaination'] ?? null,
                        ]);
                    }
                    break;
                }
            }
        }
    }
}
