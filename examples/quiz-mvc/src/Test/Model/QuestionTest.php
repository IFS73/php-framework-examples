<?php

namespace App\Test\Model;

use App\Model\Answer;
use App\Model\Question;
use Cda0521Framework\Testing\Assert;
use Cda0521Framework\Testing\Interfaces\TestCase;

final class QuestionTest implements TestCase
{
    public function getDescription(): string {
        return 'Question class';
    }

    public function execute(): void {
        // Récupère la première question en base de données, ainsi que les réponses associées
        $question = new Question(1);
        $answers = $question->getAnswers();
        // Teste si les réponses sont bien un tableau
        Assert::isArray($answers);

        // Teste que le tableau contient uniquement des objets de type "réponse"
        foreach ($answers as $answer) {
            Assert::isInstanceOf($answer, Answer::class);
        }
    }
}
