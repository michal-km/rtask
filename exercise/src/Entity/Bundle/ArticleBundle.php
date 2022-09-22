<?php

namespace Drupal\exercise\Entity\Bundle;

use Drupal\node\Entity\Node;
use Drupal\image\Entity\ImageStyle;

/**
 * A bundle class for node entities.
 */
class ArticleBundle extends Node {

  /**
   * Getter method for node title.
   *
   * @return string
   *   Returns plain text.
   */
  public function getTitle() : string {
    return $this->title->value;
  }

  /**
   * Getter method for field_description.
   *
   * @return string
   *   Returns plain text.
   */
  public function getDescription() : string {
    return $this->field_description->value;
  }

  /**
   * Getter method for styled field_image URL.
   *
   * @return string
   *   Returns url as plain text or null if not found.
   */
  public function getCroppedImageUrl() : ?string {
    try {
      $imageUri = $this->field_image->entity->getFileUri();
      $imageStyledUrl = ImageStyle::load('cropped')->buildUrl($imageUri);
    }
    catch (\Exception $e) {
      $imageStyledUrl = NULL;
    }
    return $imageStyledUrl;
  }

}
