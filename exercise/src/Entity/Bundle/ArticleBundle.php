<?php

namespace Drupal\exercise\Entity\Bundle;

use Drupal\node\Entity\Node;
use \Drupal\image\Entity\ImageStyle;

/**
 * A bundle class for node entities.
 */
class ArticleBundle extends Node {
  public function getTitle() : string
   {
   	return $this->title->value;
   }

  public function getDescription() : string
   {
    return $this->field_description->value;
   }

  public function getCroppedImageURL() : ?string
  {
  	try {
    $imageUri = $this->field_image->entity->getFileUri();
    $imageStyledUrl = ImageStyle::load('cropped')->buildUrl($imageUri);
    } catch (\Exception $e) {
    	$imageStyledUrl = null;
    }
    return $imageStyledUrl;
  }
}
