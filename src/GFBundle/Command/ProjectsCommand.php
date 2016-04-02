<?php

namespace GFBundle\Command;

require_once dirname(dirname(__FILE__)) . '/lib/libphutil/src/__phutil_library_init__.php';

use GFBundle\Service\ApiClient;
use GFBundle\Entity\Project;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;

class ProjectsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('gf:projects')
            ->setDescription('Geras Fabrikas: fetches projects via Phabricator API');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //
        /** @var ApiClient $apiClient */
        $apiClient = $this->getContainer()->get('gf.api_client');
        $projects = $apiClient->getOpenProjects();

        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('GFBundle:Project');
        $count = 0;

        foreach ($projects['data'] as $projectData) {

            if ($repository->findOneBy(['phid' => $projectData['phid']])) {
                continue;
            }

            $project = new Project();
            $project->setPhid($projectData['phid']);
            $project->setName($projectData['name']);

            $em->persist($project);
            $count++;
        }

        $em->flush();
        $output->writeln(sprintf('%d saved.', $count));
    }

    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return Registry
     *
     * @throws \LogicException If DoctrineBundle is not available
     */
    protected function getDoctrine()
    {
        if (!$this->getContainer()->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->getContainer()->get('doctrine');
    }

}
