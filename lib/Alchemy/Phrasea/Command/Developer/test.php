<?php
// *******************************************************************
// ********************** TO BE DELETED AFTER TESTS ******************
// *******************************************************************

/*
 * This file is part of Phraseanet
 *
 * (c) 2005-2016 Alchemy
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Alchemy\Phrasea\Command\Developer;

use Alchemy\Phrasea\Command\Command;
use Alchemy\Phrasea\Model\Repositories\PsSettings\Expose;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class test extends Command
{
    public function __construct()
    {
        parent::__construct('test');
    }

    protected function doExecute(InputInterface $input, OutputInterface $output)
    {
        /** @var Expose $ex */
        $ex = $this->container['ps_settings.expose'];
        foreach($ex->getInstances() as $exposeInstance) {
            $output->writeln(sprintf("expose: '%s'", $exposeInstance->getName()));
            $output->writeln(sprintf("  front-uri: '%s'", $exposeInstance->getFrontUri()));
        }
        $output->writeln('');

        $z = $ex->create("rtrrtrtrt");
        $z->setFrontUri("azeazea");
        $output->writeln(sprintf("  front-uri: '%s'", $z->getFrontUri()));
        $z->setFrontUri("wwwwwwww");
        $output->writeln(sprintf("  front-uri: '%s'", $z->getFrontUri()));

        $output->writeln('');
        foreach($ex->getInstances() as $exposeInstance) {
            $output->writeln(sprintf("expose: '%s'", $exposeInstance->getName()));
            $output->writeln(sprintf("  front-uri: '%s'", $exposeInstance->getFrontUri()));
        }

        return 0;
    }
}
