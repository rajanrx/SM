<?php
require_once 'vendor/autoload.php';
use Doctrine\Common\Annotations\AnnotationRegistry;
use SM\Lib\Services\MovieRecommendationService;
use SM\Traits\DIContainerTrait;

$movieCommand = new Commando\Command();
// Load DI container
$container = DIContainerTrait::getContainer();
// Unfortunately the annotation reader is not automatically registered on composer
// So we need to add it manually.
AnnotationRegistry::registerLoader('class_exists');

// Option for genre
$movieCommand->option('g')->aka('genre')->require()->describedAs('Movie Genre');

// Option for time
$movieCommand->option('t')->aka('time')->require()->describedAs(
    'Input time in 24 hour format (HH:MM)'
)->must(
    function ($time) {
        // Test if the input time is in 24 hour HH:MM Format
        return preg_match("/(2[0-3]|[01][0-9]):([0-5][0-9])/", $time);
    }
)->map(
    function ($time) {
        // Fixme: Use Australian timezone  AEDT as the movie data has +11:00
        return date_create_from_format(
            'H:i',
            $time,
            new DateTimeZone('+11:00')
        );
    }
);

/** @var MovieRecommendationService $movieRecommendationService */
$movieRecommendationService =
    $container->get('sm.lib.services.movie_recommendation_service');
$movies = $movieRecommendationService->getRecommendedMovie(
    $movieCommand['genre'],
    $movieCommand['time']
);

echo PHP_EOL;
if (count($movies) == 0) {
    echo "no movie recommendations" . PHP_EOL;
    exit(0);
}

foreach ($movies as $movie) {
    $showTime = $movie->getNearestShowingDate($movieCommand['time'], 'h:i a');
    echo "{$movie->name}, showing at {$showTime} " . PHP_EOL;
}

echo PHP_EOL;
exit(0);
