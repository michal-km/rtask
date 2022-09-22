<?php
namespace Drupal\Tests\exercise\Functional;

use Drupal\Tests\rest\Functional\ResourceTestBase;
use Psr\Http\Message\ResponseInterface;
use Drupal\Core\Url;
use GuzzleHttp\RequestOptions;

class RestTest extends ResourceTestBase {

/**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'classy';


	public function testAccess() {
		$request_options = [];
    $request_options[RequestOptions::HEADERS]['Accept'] = static::$mimeType;
    $request_options[RequestOptions::HEADERS]['Content-Type'] = static::$mimeType;
    $request_options[RequestOptions::BODY] = '{}';
    $url = Url::fromUserInput('/article/all');
    $response = $this->request('GET', $url, $request_options);

	$this->assertSame(200, $response->getStatusCode());
	}

/**
   * {@inheritdoc}
   */
  protected function setUpAuthorization($method) {

  }

  /**
   * {@inheritdoc}
   */
  protected function getExpectedUnauthorizedAccessCacheability() {
    return new CacheableMetadata();
  }

  /**
   * {@inheritdoc}
   */
  protected function assertAuthenticationEdgeCases($method, Url $url, array $request_options) {

  }

  /**
   * {@inheritdoc}
   */
  protected function assertNormalizationEdgeCases($method, Url $url, array $request_options) {

  }

  /**
   * {@inheritdoc}
   */
  protected function assertResponseWhenMissingAuthentication($method, ResponseInterface $response) {

  }
}