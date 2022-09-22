<?php
namespace Drupal\Tests\exercise\Unit;

use Drupal\Tests\UnitTestCase;
use Drupal\exercise\Entity\Bundle\ArticleBundle;

class ArticleBundleTest extends UnitTestCase {
	public function testCreate() {
		$ab = new ArticleBundle();
		$this->assertInstanceOf(Drupal\exercise\ArticleBundle);
	}
}