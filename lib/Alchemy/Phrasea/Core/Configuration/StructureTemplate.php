<?php

/*
 * This file is part of Phraseanet
 *
 * (c) 2005-2016 Alchemy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Alchemy\Phrasea\Core\Configuration;

use Alchemy\Phrasea\Application;

/**
 * Class StructureTemplate
 * @package Alchemy\Phrasea\Core\Configuration
 */
class StructureTemplate
{
    const TEMPLATE_EXTENSION = 'xml';
    const DEFAULT_TEMPLATE = 'en-simple';

    /** @var  string */
    private $rootPath;

    /** @var  \SplFileInfo[] */
    private $templates;

    /**
     * @param string $rootPath
     */
    public function __construct($rootPath)
    {
        $this->rootPath = $rootPath;
        $this->templates = null;    // lazy loaded, not yet set
    }

    /**
     * @return $this
     * @throws \Exception
     */
    private function load()
    {
        if(!is_null($this->templates)) {
            return;     // already loaded
        }

        $templateList = new \DirectoryIterator($this->rootPath . '/lib/conf.d/data_templates');

        $this->templates = [];
        foreach ($templateList as $template) {
            if ($template->isDot()
                || !$template->isFile()
                || $template->getExtension() !== self::TEMPLATE_EXTENSION
            ) {
                continue;
            }

            $name = $template->getBasename('.' . self::TEMPLATE_EXTENSION);
            // beware that the directoryiterator returns a reference on a static, so clone()
            $this->templates[$name] = clone($template);
        }
    }

    /**
     * @param string $templateName
     * @return \SplFileInfo | null
     */
    public function getByName($templateName)
    {
        $this->load();

        if (!array_key_exists($templateName, $this->templates)) {
            return null;
        }

        return $this->templates[$templateName];
    }

    /**
     * @param $index
     * @return null|\SplFileInfo
     */
    public function getNameByIndex($index)
    {
        static $indexToKey = null;
        if(is_null($indexToKey)) {
            $indexToKey = array_keys($this->templates);
        }

        return $indexToKey[$index];
    }

    public function toString()
    {
        $this->load();

        return implode(', ', array_keys($this->templates));
    }

    /**
     * @return string
     */
    public function getDefault()
    {
        $this->load();

        return $this->getByName(self::DEFAULT_TEMPLATE) ? self::DEFAULT_TEMPLATE : $this->getNameByIndex(0);
    }
}