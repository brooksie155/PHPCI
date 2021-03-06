<?php
/**
 * PHPCI - Continuous Integration for PHP
 *
 * @copyright    Copyright 2013, Block 8 Limited.
 * @license      https://github.com/Block8/PHPCI/blob/master/LICENSE.md
 * @link         http://www.phptesting.org/
 */

namespace PHPCI\Plugin;

/**
 * PHP Loc - Allows PHP Copy / Lines of Code testing.
 * @author       Johan van der Heide <info@japaveh.nl>
 * @package      PHPCI
 * @subpackage   Plugins
 */
class PhpLoc implements \PHPCI\Plugin
{
    /**
     * @var string
     */
    protected $directory;
    /**
     * @var \PHPCI\Builder
     */
    protected $phpci;

    public function __construct(\PHPCI\Builder $phpci, array $options = array())
    {
        $this->phpci     = $phpci;
        $this->directory = isset($options['directory']) ? $options['directory'] : $phpci->buildPath;
    }

    /**
     * Runs PHP Copy/Paste Detector in a specified directory.
     */
    public function execute()
    {
        $ignore = '';
        if (count($this->phpci->ignore)) {
            $map    = function ($item) {
                return ' --exclude ' . (substr($item, -1) == '/' ? substr($item, 0, -1) : $item);
            };
            $ignore = array_map($map, $this->phpci->ignore);

            $ignore = implode('', $ignore);
        }

        return $this->phpci->executeCommand(PHPCI_BIN_DIR . 'phploc %s "%s"', $ignore, $this->phpci->buildPath);
    }
}