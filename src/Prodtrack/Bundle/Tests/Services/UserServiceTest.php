<?php
namespace OAUth\OAuthBundle\Tests\Services;

use Prodtrack\Bundle\Entity\User;
use Prodtrack\Bundle\Services\UserService;

class UserServiceTest extends \PHPUnit_Framework_TestCase
{
    protected $validUser;
    protected $invalidUser;

    public function setUp()
    {
        $this->validUser = new User();
        $this->validUser->setEmail('bb@bb.com');
        $this->validUser->setLastLogin(new \DateTime());
        $this->validUser->setPassword('bb');
        $this->validUser->setUsername('bb');
        $this->validUser->setRegisterDate(new \DateTime());

        $this->invalidUser = null;
    }

    public function testValidateSuccess()
    {
        $userRepoMock = $this->getMockBuilder('\Prodtrack\Bundle\Repository\UserRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $userRepoMock->expects($this->once())
            ->method('getUserWithCredentials')
            ->with('bb', 'bb')
            ->will($this->returnValue($this->validUser));

        $emMock = $this->getMockBuilder('\Doctrine\Common\Persistence\ObjectManager')
            ->disableOriginalConstructor()
            ->getMock();
        $emMock->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($userRepoMock));

        /** @var  $userService */
        $userService = new UserService($emMock);
        $user = $userService->getUserWithCredentials('bb', 'bb');

        $this->assertTrue($user instanceof User);
    }

    public function testValidateNotFound()
    {
        $userRepoMock = $this->getMockBuilder('\Prodtrack\Bundle\Repository\UserRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $userRepoMock->expects($this->once())
            ->method('getUserWithCredentials')
            ->with('bb', 'bb')
            ->will($this->returnValue($this->invalidUser));

        $emMock = $this->getMockBuilder('\Doctrine\Common\Persistence\ObjectManager')
            ->disableOriginalConstructor()
            ->getMock();
        $emMock->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($userRepoMock));

        /** @var  $userService */
        $userService = new UserService($emMock);
        $user = $userService->getUserWithCredentials('bb', 'bb');

        $this->assertNull($user);
    }
}