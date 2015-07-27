<?php

namespace SlmQueueBeanstalkd\Factory;

use SlmQueueBeanstalkd\Queue\BeanstalkdQueue;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * BeanstalkdQueueFactory
 */
class BeanstalkdQueueFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator, $name = '', $requestedName = '')
    {
        $parentLocator    = $serviceLocator->getServiceLocator();
        $pheanstalk       = $parentLocator->get('SlmQueueBeanstalkd\Service\PheanstalkService');
        $jobPluginManager = $parentLocator->get('SlmQueue\Job\JobPluginManager');

        //Getting beanstalkd tube name
        /** @var $beanstalkdOptions \SlmQueueBeanstalkd\Options\BeanstalkdOptions */
        $beanstalkdOptions = $parentLocator->get('SlmQueueBeanstalkd\Options\BeanstalkdOptions');
        $tubes = $beanstalkdOptions->getTubes();
        $tubeName = (empty($tubes[$requestedName])? null : $tubes[$requestedName]);

        return new BeanstalkdQueue($pheanstalk, $requestedName, $jobPluginManager, $tubeName);
    }

}
