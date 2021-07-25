<?php

require_once __DIR__ . './vendor/autoload.php';

use App\Model\Answer;
use App\Model\Question;
use Cda0521Framework\Service\FlashMessages\FlashMessage;
use Cda0521Framework\Service\FlashMessages\FlashMessagesService;

$flashMessagesService = new FlashMessagesService();

// Vérifie si l'utilisateur vient de répondre à une question
$formSubmitted = $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer']) && isset($_POST['current-question']);

// Si l'utilisateur vient de répondre à une question
if ($formSubmitted) {
  // Récupère la question précédente en base de données avec sa bonne réponse
  $previousQuestion = Question::findById($_POST['current-question']);
  // Vérifie si la réponse fournie par l'utilisateur correspond à la bonne réponse à la question précédente
  $rightlyAnswered = intval($_POST['answer']) === $previousQuestion->getRightAnswer()->getId();

  // Ajoute un message flash en fonction de la réussite de l'utilisateur
  if ($rightlyAnswered) {
    $flashMessage = new FlashMessage('Bravo, c\'était la bonne réponse!', 'success');
  } else {
    $flashMessage = new FlashMessage('Hé non! La bonne réponse était: ' . $previousQuestion->getRightAnswer()->getText(), 'danger');
  }
  $flashMessagesService->addMessage($flashMessage);
}

// Récupère la question actuelle en base de données
$question = Question::findById(1);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <!------ Include the above in your HEAD tag ---------->   
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" rel="stylesheet" />
</head>
<body>
  <div class="container">
    <h1>Quizz</h1>

    <?php foreach ($flashMessagesService->getMessages() as $message): ?>
    <!-- Affiche une alerte pour chaque message flash présent dans la session (par défaut, il n'y en a aucune) -->
    <div id="answer-result" class="alert alert-<?= $message->getType() ?>">
      <?= $message->getMessage() ?>
    </div>
    <?php endforeach; ?>

    <h2 class="mt-4">Question n°<span id="question-id"><?= $question->getRank() ?></span></h2>
    <form id="question-form" method="post">
      <p id="current-question-text" class="question-text"><?= $question->getText() ?></p>

      <div id="answers" class="d-flex flex-column">

        <?php foreach ($question->getAnswers() as $answer): ?>
        <div class="custom-control custom-radio mb-2">
          <input class="custom-control-input" type="radio" name="answer" id="answer<?= $answer->getId() ?>" value="<?= $answer->getId() ?>">
          <label class="custom-control-label" for="answer<?= $answer->getId() ?>" id="answer<?= $answer->getId() ?>-caption"><?= $answer->getText() ?></label>
        </div>
        <?php endforeach; ?>

      </div>
      
      <input type="hidden" name="current-question" value="<?= $question->getId() ?>" />
      <button type="submit" class="btn btn-primary">Valider</button>
    </form>
  </div>
</body>
</html>
