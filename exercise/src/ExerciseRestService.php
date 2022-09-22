<?php

namespace Drupal\exercise;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\exercise\Entity\Bundle\ArticleBundle;

/**
 * Class ExerciseRestService
 * @package Drupal\exercise\Services
 */
class ExerciseRestService {
  /**
  * Injected EntityTypeManager service
  * @var \Drupal\Core\Entity\EntityTypeManager
  */
  protected $entityTypeManager;

  /**
   * CustomService constructor.
   * @param \Drupal\Core\Entity\EntityTypeManager $entityTypeManager
   */
  public function __construct(EntityTypeManager $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }

  public function getArticleData($node) : array {
   return [
      'title' => $node->getTitle(),
      'description' => $node->getDescription(),
      'image' => $node->getCroppedImageURL(),
   ];
  }

  public function loadAllArticles() {
    $query = $this->entityTypeManager->getStorage('node')->getQuery();
    $query->condition('type', 'article')
          ->condition('status', TRUE)
          ->sort('created', 'DESC');
    $nids = $query->execute();
    $nodes = $this->entityTypeManager->getStorage('node')
                  ->loadMultiple($nids);
     return $nodes;
  	}

   public function getAllArticlesData() {
   	$result = [];
   	$nodes = $this->loadAllArticles();
    foreach ($nodes as $node) {
      if ($node instanceOf ArticleBundle)
       {
        $result[] = $this->getArticleData($node);
       }
  	}
  	return $result; 
  }

 }