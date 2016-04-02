<?php

namespace GFBundle\Command;

use GFBundle\Entity\Project;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ProjectsCommand
 *
 * @package GFBundle\Command
 */
class ProjectsCommand extends ApiCommand
{
    protected function configure()
    {
        $this
            ->setName('gf:projects')
            ->setDescription('Geras Fabrikas: fetches projects via Phabricator API');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $apiClient = $this->getApiClient();
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

}
