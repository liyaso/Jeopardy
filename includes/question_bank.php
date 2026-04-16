<?php
// Contains all the questions needed, these are blank for now, fill in later
function get_question(int $cat, int $pts): array{
    $questions = [
        // The categories index starts at 0 and ends at n-1, which is 5
        
        // Category 1
        0 => [
            200 => ['clue' => 'Category 1 - $200 clue goes here', 'answer' => 'answer1'],
            400 => ['clue' => 'Category 1 - $400 clue goes here', 'answer' => 'answer2'],
            600 => ['clue' => 'Category 1 - $600 clue goes here', 'answer' => 'answer3'],
            800 => ['clue' => 'Category 1 - $800 clue goes here', 'answer' => 'answer4'],
            1000 => ['clue' => 'Category 1 - $1000 clue goes here', 'answer' => 'answer5'],
        ],
        
        // Category 2
        1 => [
            200 => ['clue' => 'Category 2 - $200 clue goes here', 'answer' => 'answer1'],
            400 => ['clue' => 'Category 2 - $400 clue goes here', 'answer' => 'answer2'],
            600 => ['clue' => 'Category 2 - $600 clue goes here', 'answer' => 'answer3'],
            800 => ['clue' => 'Category 2 - $800 clue goes here', 'answer' => 'answer4'],
            1000 => ['clue' => 'Category 2 - $1000 clue goes here', 'answer' => 'answer5'],
        ],
        
        // Category 3
        2 => [
            200 => ['clue' => 'Category 3 - $200 clue goes here', 'answer' => 'answer1'],
            400 => ['clue' => 'Category 3 - $400 clue goes here', 'answer' => 'answer2'],
            600 => ['clue' => 'Category 3 - $600 clue goes here', 'answer' => 'answer3'],
            800 => ['clue' => 'Category 3 - $800 clue goes here', 'answer' => 'answer4'],
            1000 => ['clue' => 'Category 3 - $1000 clue goes here', 'answer' => 'answer5'],
        ],
        
        // Category 4
        3 => [
            200 => ['clue' => 'Category 4 - $200 clue goes here', 'answer' => 'answer1'],
            400 => ['clue' => 'Category 4 - $400 clue goes here', 'answer' => 'answer2'],
            600 => ['clue' => 'Category 4 - $600 clue goes here', 'answer' => 'answer3'],
            800 => ['clue' => 'Category 4 - $800 clue goes here', 'answer' => 'answer4'],
            1000 => ['clue' => 'Category 4 - $1000 clue goes here', 'answer' => 'answer5'],
        ],
        
        // Category 5
        4 => [
            200 => ['clue' => 'Category 5 - $200 clue goes here', 'answer' => 'answer1'],
            400 => ['clue' => 'Category 5 - $400 clue goes here', 'answer' => 'answer2'],
            600 => ['clue' => 'Category 5 - $600 clue goes here', 'answer' => 'answer3'],
            800 => ['clue' => 'Category 5 - $800 clue goes here', 'answer' => 'answer4'],
            1000 => ['clue' => 'Category 5 - $1000 clue goes here', 'answer' => 'answer5'],
        ],
        
        // Category 6
        5 => [
            200 => ['clue' => 'Category 6 - $200 clue goes here', 'answer' => 'answer1'],
            400 => ['clue' => 'Category 6 - $400 clue goes here', 'answer' => 'answer2'],
            600 => ['clue' => 'Category 6 - $600 clue goes here', 'answer' => 'answer3'],
            800 => ['clue' => 'Category 6 - $800 clue goes here', 'answer' => 'answer4'],
            1000 => ['clue' => 'Category 6 - $1000 clue goes here', 'answer' => 'answer5'],
        ]
    ];

    return $questions[$cat][$pts] ?? ['clue' => 'Question not found', 'answer' => ''];
}

?>