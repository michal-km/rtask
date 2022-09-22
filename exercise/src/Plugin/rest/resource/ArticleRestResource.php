<?php

namespace Drupal\exercise\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Psr\Log\LoggerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use \Drupal\Core\Entity\EntityTypeManager;
use \Drupal\image\Entity\ImageStyle;

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
   * Injected EntityTypeManager service
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;
  
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
   * @param \Drupal\Core\Entity\EntityTypeManager $entityTypeManager
   *   Entity Type Manager service (injected).
   */
  public function __construct(
    array $config,
    $module_id,
    $module_definition,
    array $serializer_formats,
    LoggerInterface $logger,
    EntityTypeManager $entityTypeManager) {
    parent::__construct($config, $module_id, $module_definition, $serializer_formats, $logger);
    $this->entityTypeManager = $entityTypeManager;
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
      $container->get('entity_type.manager'),
    );
  }

  /**
   * Returns complete list of articles.
   * @throws \Symfony\Component\HttpKernel\Exception\HttpException
   */
  public function get() {
    $result = [];
    $query = $this->entityTypeManager->getStorage('node')->getQuery();
    $query->condition('type', 'article');
          ->condition('status', TRUE)
          ->sort('created', 'DESC')
    $nids = $query->execute();
    $nodes = $this->entityTypeManager->getStorage('node')
                  ->loadMultiple($nids);
  	foreach ($nodes as $node) {
      $imageUri = $node->field_image->entity->getFileUri();
      $imageUrl = ImageStyle::load('cropped')->buildUrl($imageUri);
	    $result[] = array(
	  	  'title' => $node->title->value,
        'description' => $node->field_description->value,
        'image' => $imageUrl,
	    );
  	}
    $response = new ResourceResponse($result);
    $response->addCacheableDependency($result);
    return $response;
  }

}