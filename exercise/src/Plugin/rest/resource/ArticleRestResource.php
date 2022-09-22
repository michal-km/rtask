<?php

namespace Drupal\exercise\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Psr\Log\LoggerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use \Drupal\exercise\ExerciseRestService;

/**
 * Provides a resource to get all articles via GET method
 * @RestResource(
 *   id = "article_rest_resource",
 *   label = @Translation("Article Rest Resource"),
 *   uri_paths = {
 *     "canonical" = "/article/all"
 *   }
 * )
 */
class ArticleRestResource extends ResourceBase {

  /**
   * Injected ExerciseRestService
   * @var \Drupal\exercise\ExerciseRestService
   */
  protected $exerciseRestService;
  
  /**
   * Constructs a Drupal\rest\Plugin\ResourceBase object.
   *
   * @param array $config
   *   Plugin instance information
   * @param string $module_id
   *   Module_id for the plugin instance.
   * @param mixed $module_definition
   *   Plugin implementation definition.
   * @param array $serializer_formats
   *   Serialization formats.
   * @param \Psr\Log\LoggerInterface $logger
   *   A logger.
   * @param \Drupal\exercise\ExerciseRestService $exerciseRestService
   *   ExerciseRestService (injected).
   */
  public function __construct(
    array $config,
    $module_id,
    $module_definition,
    array $serializer_formats,
    LoggerInterface $logger,
    ExerciseRestService $exerciseRestService) {
    parent::__construct($config, $module_id, $module_definition, $serializer_formats, $logger);
    $this->exerciseRestService = $exerciseRestService;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $config, $module_id, $module_definition) {
    return new static(
      $config,
      $module_id,
      $module_definition,
      $container->getParameter('serializer.formats'),
      $container->get('logger.factory')->get('article_rest_resource'),
      $container->get('exercise.rest'),
    );
  }

  /**
   * Returns complete list of articles.
   * @throws \Symfony\Component\HttpKernel\Exception\HttpException
   */
  public function get() {
    $data = $this->exerciseRestService->getAllArticlesData();
    $response = new ResourceResponse($data);
    $response->addCacheableDependency($data);
    return $response;
  }

}