<?php
namespace Prodtrack\ApiBundle\Tests\EventListener;

use Prodtrack\ApiBundle\Controller\DefaultController;
use Prodtrack\ApiBundle\EventListener\ContentNegotiator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ContentNegotiatorTest extends \PHPUnit_Framework_TestCase
{
    public function testOnKernelControllerAll()
    {
        $eventMock = $this->getControllerEvent('*/*');

        $cn = new ContentNegotiator();
        $cn->onKernelController($eventMock);
        $attribute = $eventMock->getRequest()->attributes->get('Content-Type');

        $this->assertEquals(ContentNegotiator::CONTENT_COLLECTION_JSON, $attribute);
    }

    public function testOnKernelControllerCollectionJson()
    {
        $eventMock = $this->getControllerEvent(ContentNegotiator::CONTENT_COLLECTION_JSON);

        $cn = new ContentNegotiator();
        $cn->onKernelController($eventMock);
        $attribute = $eventMock->getRequest()->attributes->get('Content-Type');

        $this->assertEquals(ContentNegotiator::CONTENT_COLLECTION_JSON, $attribute);
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException
     */
    public function testOnKernelControllerOther()
    {
        $eventMock = $this->getControllerEvent('application/json');

        $cn = new ContentNegotiator();
        $cn->onKernelController($eventMock);
        $attribute = $eventMock->getRequest()->attributes->get('Content-Type');

        $this->assertEquals(ContentNegotiator::CONTENT_COLLECTION_JSON, $attribute);
    }

    public function testOnKernelResponseCollectionJson()
    {
        $eventMock = $this->getResponseEvent(ContentNegotiator::CONTENT_COLLECTION_JSON);

        $cn = new ContentNegotiator();
        $cn->onKernelResponse($eventMock);
        $contentType = $eventMock->getResponse()->headers->get('Content-Type');

        $this->assertEquals(ContentNegotiator::CONTENT_COLLECTION_JSON, $contentType);
    }

    public function testOnKernelResponseNoContentType()
    {
        $eventMock = $this->getResponseEvent(ContentNegotiator::CONTENT_COLLECTION_JSON);

        $cn = new ContentNegotiator();
        $cn->onKernelResponse($eventMock);
        $contentType = $eventMock->getResponse()->headers->get('');

        $this->assertNotEquals(ContentNegotiator::CONTENT_COLLECTION_JSON, $contentType);
    }

    /**
     * @param string $acceptHeader
     * @return \Symfony\Component\HttpKernel\Event\FilterControllerEvent
     */
    protected function getControllerEvent($acceptHeader)
    {
        $controller = array(
            new DefaultController()
        );

        $request = new Request();
        $request->headers->add(array('Accept' => $acceptHeader));

        $mock = $this->getMockBuilder('\Symfony\Component\HttpKernel\Event\FilterControllerEvent')
            ->disableOriginalConstructor()
            ->getMock();

        $mock->expects($this->once())
            ->method('getController')
            ->will($this->returnValue($controller));

        $mock->expects($this->any())
            ->method('getRequest')
            ->will($this->returnValue($request));

        return $mock;
    }

    /**
     * @param string $contentTypeHeader
     * @return \Symfony\Component\HttpKernel\Event\FilterResponseEvent
     */
    protected function getResponseEvent($contentTypeHeader)
    {
        $request = new Request();
        $request->attributes->set('Content-Type', $contentTypeHeader);

        $response = new Response('', 200, array());

        $mock = $this->getMockBuilder('\Symfony\Component\HttpKernel\Event\FilterResponseEvent')
            ->disableOriginalConstructor()
            ->getMock();

        $mock->expects($this->once())
            ->method('getRequest')
            ->will($this->returnValue($request));

        $mock->expects($this->any())
            ->method('getResponse')
            ->will($this->returnValue($response));

        return $mock;
    }
}