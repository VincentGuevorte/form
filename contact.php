<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require __DIR__.'/vendor/autoload.php';

// instanciation du chargeur de templates
$loader = new FilesystemLoader(__DIR__.'/templates');

// instanciation du moteur de template
$twig = new Environment($loader);

// traitement des données
$errors = [];

dump($_POST);



if ($_POST) {

    $maxLengthMail = 190;

    if (empty($_POST['email'])) {
        $errors['email'] = 'merci de renseigner ce champ';
    } elseif (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false) {
        $errors['email'] = 'merci de renseigner un email valide';
    }elseif (strlen($_POST['mail']) > 190) {
        // la longueur du mail est-elle hors des limites ?
        $errors['email'] = "merci de renseigner un mail dont la longueur ne depasse pas {$maxLengthMail} inclus";
    }

    $minLengthSubject = 3;
    $maxLengthSubject = 190;

    if (empty($_POST['subject'])) {
        // le champs est-il vide ?
        $errors['subject'] = 'merci de renseigner ce champ';
    } elseif (strlen($_POST['subject']) < 3 || strlen($_POST['subject']) > 190) {
        // la longueur du subject est-elle hors des limites ?
        $errors['subject'] = "merci de renseigner un subject dont la longueur est comprise entre {$minLengthSubject} et {$maxLengthSubject} inclus";
    } elseif (preg_match('/^[a-zA-Z]+$/', $_POST['subject']) === 0) {
        // le subject est-il composé exclusivement de lettres de a à z, majuscules ou mnisucules ?
        $errors['subject'] = 'merci de renseigner un subject composé uniquement de lettres de l\'alphabet sans accent';
    }

    $minLengthTextarea = 3;
    $maxLengthTextarea = 1000;

    if (empty($_POST['textarea'])) {
        // le champs est-il vide ?
        $errors['textarea'] = 'merci de renseigner ce champ';
    } elseif (strlen($_POST['textarea']) < 3 || strlen($_POST['textarea']) > 1000) {
        // la longueur du textarea est-elle hors des limites ?
        $errors['textarea'] = "merci de renseigner un textarea dont la longueur est comprise entre {$minLengthtextarea} et {$maxLengthtextarea} inclus";
    } elseif (preg_match('/^[a-zA-Z]+$/', $_POST['textarea']) === 0) {
        // le textarea est-il composé exclusivement de lettres de a à z, majuscules ou mnisucules ?
        $errors['textarea'] = 'merci de renseigner un textarea composé uniquement de lettres de l\'alphabet sans accent';
    }
}
// affichage du rendu d'un template
echo $twig->render('contact.html.twig', [
    // transmission de données au template
    'errors' => $errors,
]);