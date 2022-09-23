<?php

namespace Drupal\exercise;

use Drupal\Core\Entity\EntityTypeManager;
use Drupal\exercise\Entity\Bundle\ArticleBundle;

/**
 * Data handling logic for REST resource.
 *
 * @package Drupal\exercise\Services
 */
class ExerciseRestService {
  /**
   * Injected EntityTypeManager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * CustomService constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManager $entityTypeManager
   *   Service for querying data.
   */
  public function __construct(EntityTypeManager $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * Gets node data in plain text format.
   *
   * @param mixed $node
   *   Instance of ArticleBundle.
   *
   * @return array
   *   Array to be returned in JSON response.
   */
  protected function getArticleData($node) : array {
    return [
      'title' => $node->getTitle(),
      'description' => $node->getDescription(),
      'image' => $node->getCroppedImageUrl(),
    ];
  }

  /**
   * Loads all available nodes of type article.
   */
  protected function loadAllArticles() {
    $query = $this->entityTypeManager->getStorage('node')->getQuery();
    $query->condition('type', 'article')
      ->condition('status', TRUE)
      ->sort('created', 'DESC');
    $nids = $query->execute();
    $nodes = $this->entityTypeManager->getStorage('node')
      ->loadMultiple($nids);
    return $nodes;
  }

  /**
   * Returns an array of article nodes for REST resource.
   *
   * @return array
   *   Array to be returned in JSON response.
   */
  public function getAllArticlesData() : array {
    $result = [];
    $nodes = $this->loadAllArticles();
    foreach ($nodes as $node) {
      if ($node instanceof ArticleBundle) {
        $result[] = $this->getArticleData($node);
      }
    }
    return $result;
  }

}
