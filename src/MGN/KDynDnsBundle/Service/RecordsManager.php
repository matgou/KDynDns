<?php

namespace MGN\KDynDnsBundle\Service;

use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Bridge\Monolog\Logger;
use Doctrine\ORM\EntityManager;
use \Swift_Mailer as Mailer;

use MGN\KDynDnsBundle\Entity\Records;

class RecordsManager
{

    private $logger;
    private $mailer;
    private $templating;
    private $entityManager;

    public function __construct(Logger $logger, Mailer $mailer, TwigEngine $templating, EntityManager $entityManager)
    {

        $this->logger=$logger;
        $this->mailer=$mailer;
        $this->templating=$templating;
        $this->entityManager=$entityManager;
    }

    public function updateIP(Records $records, $ip)
    {
        $this->logger->info(sprintf("Update records : %s to ip : %s", $records, $ip));
        exec(sprintf(dirname(__FILE__) . '/../../../../scripts/dnsupdate.sh %s %s', $records, $ip));
        // TODO
    }
    /**
     * Add an record in database and send email
     */
    public function add(Records $records)
    {
        $this->logger->info(sprintf("Add new records : %s", $records));
        $this->entityManager->persist($records);
        $this->entityManager->flush();

        $this->logger->info(sprintf("Send token by email to %s", $records->getEmail()));
        $message = \Swift_Message::newInstance()
          ->setSubject(sprintf('[KDynDns] Enregistrement de %s', $records->__toString()))
          ->setFrom('mathieu.goulin@gadz.org')
          ->setTo($records->getEmail())
          ->setBody($this->templating->render('MGNKDynDnsBundle:Api:email.txt.twig', array('records' => $records)))
        ;
        $this->mailer->send($message);

        return $records;
    }
}
