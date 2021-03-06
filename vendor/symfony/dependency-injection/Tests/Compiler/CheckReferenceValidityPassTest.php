<?php
/*
 * @ PHP 5.6
 * @ Decoder version : 1.0.0.1
 * @ Release on : 24.03.2018
 * @ Website    : http://EasyToYou.eu
 */

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Symfony\Component\DependencyInjection\Tests\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CheckReferenceValidityPass;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
class CheckReferenceValidityPassTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \RuntimeException
     */
    public function testProcessDetectsReferenceToAbstractDefinition()
    {
        $container = new ContainerBuilder();
        $container->register('a')->setAbstract(true);
        $container->register('b')->addArgument(new Reference('a'));
        $this->process($container);
    }
    public function testProcess()
    {
        $container = new ContainerBuilder();
        $container->register('a')->addArgument(new Reference('b'));
        $container->register('b');
        $this->process($container);
    }
    protected function process(ContainerBuilder $container)
    {
        $pass = new CheckReferenceValidityPass();
        $pass->process($container);
    }
}

?>