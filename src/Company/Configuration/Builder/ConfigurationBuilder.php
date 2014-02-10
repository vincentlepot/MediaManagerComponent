<?php

namespace CanalTP\MediaManager\Company\Configuration\Builder;

use CanalTP\MediaManager\Company\Configuration\Builder\ConfigurationBuilderInterface;
use CanalTP\MediaManager\Company\Configuration\Configuration;
use CanalTP\MediaManager\Strategy\DefaultStrategy;
use CanalTP\MediaManager\Strategy\MttStrategy;
use CanalTP\MediaManager\Strategy\NavitiaStrategy;
use CanalTP\MediaManager\Storage\FileSystem;

class ConfigurationBuilder implements ConfigurationBuilderInterface
{
    private $configuration = null;

    private function getConfiguration()
    {
        return ($this->configuration);
    }

    private function initFileSystemStorage($company)
    {
        $filesystem = new FileSystem();

        $filesystem->setPath($company['storage']['path']);
        $this->configuration->setStorage($filesystem);
    }

    private function initStorage($company)
    {
        switch ($company['storage']['type']) {
            case 'filesystem':
                $this->initFileSystemStorage($company);
                break;
        }
    }

    private function initStrategy($company)
    {
        switch ($company['strategy']) {
            case 'default':
                $this->configuration->setStrategy(new DefaultStrategy());
                break;
            case 'mtt':
                $this->configuration->setStrategy(new MttStrategy());
                break;
            case 'navitia':
                $this->configuration->setStrategy(new NavitiaStrategy());
                break;
        }
    }

    public function buildConfiguration($company)
    {
        $this->configuration = new Configuration();

        $this->initStorage($company);
        $this->initStrategy($company);

        return ($this->getConfiguration());
    }
}
