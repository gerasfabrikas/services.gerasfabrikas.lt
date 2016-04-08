<?php

namespace GFBundle\Command;

use GFBundle\Entity\Task;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TasksCommand extends ApiCommand
{
    /** @var array */
    private $categories = null;


    protected function configure()
    {
        $this
            ->setName('gf:tasks')
            ->setDescription('Geras Fabrikas: fetches tasks via Phabricator API');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $apiClient = $this->getApiClient();
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('GFBundle:Task');
        $count = 0;

        foreach ($apiClient->getTasks() as $data) {

            if (null === ($task = $repository->findOneBy(['phid' => $data['phid']]))) {
                $task = new Task();
                $task->setPhid($data['phid']);
                $task->setTaskId($data['id']);
            }

            if (!empty($data['projectPHIDs'][0])) {
                $task->setProject($data['projectPHIDs'][0]);
            }

            if (!empty($data['ownerPHID'])) {
                $task->setOwner($data['ownerPHID']);
            }

            if (!empty($data['auxiliary']['std:maniphest:gerasfabrikas:actual-hours'])) {
                $task->setHours($data['auxiliary']['std:maniphest:gerasfabrikas:actual-hours']);
            }

            if (!empty($data['auxiliary']['std:maniphest:gerasfabrikas:job-category'])) {
                $categoryId = $this->getCategoryByReference($data['auxiliary']['std:maniphest:gerasfabrikas:job-category']);
                $task->setCategoryId($categoryId);
            }

            $task->setAuthor($data['authorPHID']);
            $task->setStatus($data['status']);
            $task->setTitle($data['title']);
            $task->setDescription($data['description']);
            $task->setDateCreated($data['dateCreated']);
            $task->setDateModified($data['dateModified']);

            $em->persist($task);
            $count++;
        }

        $em->flush();
        $output->writeln(sprintf('%d saved.', $count));
    }

    /**
     * @param string $reference
     *
     * @return string
     */
    private function getCategoryByReference($reference)
    {
        if (!isset($this->categories)) {
            $this->categories = $this->getCategories();
        }

        return isset($this->categories[$reference]) ? $this->categories[$reference] : '';
    }

    /**
     * @return array
     */
    private function getCategories()
    {
        $result = [];
        $repository = $this->getDoctrine()->getRepository('GFBundle:Category');
        $data = $repository->findAll();

        foreach ($data as $category) {
            $result[$category->getReference()] = $category->getId();
        }

        return $result;
    }

}
