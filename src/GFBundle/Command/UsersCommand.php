<?php

namespace GFBundle\Command;

use GFBundle\Entity\User;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UsersCommand
 *
 * @package GFBundle\Command
 */
class UsersCommand extends ApiCommand
{
    protected function configure()
    {
        $this
            ->setName('gf:users')
            ->setDescription('Geras Fabrikas: fetches users via Phabricator API');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $apiClient = $this->getApiClient();
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('GFBundle:User');

        $users = $apiClient->getUsers();
        $count = 0;
        foreach ($users as $data) {

            if ($repository->findOneBy(['phid' => $data['phid']])) {
                continue;
            }

            $user = new User();
            $user->setPhid($data['phid']);
            $user->setUsername($data['userName']);
            $user->setRealname($data['realName']);
            $user->setImage($data['image']);
            $user->setCompany('');

            $em->persist($user);
            $count++;
        }

        $em->flush();
        $output->writeln(sprintf('%d saved.', $count));
    }

}
