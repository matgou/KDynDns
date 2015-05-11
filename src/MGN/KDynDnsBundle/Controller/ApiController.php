<?php

namespace MGN\KDynDnsBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use MGN\KDynDnsBundle\Entity\Zone;
use MGN\KDynDnsBundle\Entity\Records;
use MGN\KDynDnsBundle\Form\RecordsType;

class ApiController extends FOSRestController
{


    public function newRecordsAction()
    {
        $form=$this->createForm(new RecordsType());
        
        $view = $this->view($form, 200)
            ->setTemplate("MGNKDynDnsBundle:Api:newRecords.html.twig")
            ->setTemplateVar('form')
        ;
        return $this->handleView($view);
    }

    public function putRefreshAction(Request $request)
    {
        $token=$request->request->get('token');
        $fqdn=$request->request->get('fqdn');
        
	$records=$this->container->get('doctrine.orm.entity_manager')->getRepository('MGNKDynDnsBundle:Records')->findByTokenAndFqdn($token,$fqdn);

        if($records) 
        { 
            $ip = $request->getClientIp();
            $data=$this->get("mgnk_dyn_dns.records_manager")->updateIP($records, $ip);

            $view = $this->view($ip, 200)
                ->setTemplate("MGNKDynDnsBundle:Api:refreshRecords.html.twig")
                ->setTemplateVar('records')
            ;
            return $this->handleView($view);
       }
       throw $this->createNotFoundException();
    }

    public function postRecordsAction(Request $request)
    {
        $records = new Records();
        $form = $this->createForm(new RecordsType(), $records);
        $form->submit($request);
        if ($form->isValid()) {
            if($this->container->get('doctrine.orm.entity_manager')->getRepository('MGNKDynDnsBundle:Records')->Exist($records) == 0)
            {
                $records=$this->get("mgnk_dyn_dns.records_manager")->add($records);

                $view = $this->view($records, 200)
                    ->setTemplate("MGNKDynDnsBundle:Api:postRecords.html.twig")
                    ->setTemplateVar('records')
                ;
                return $this->handleView($view);
            }
            $form->get('name')->addError(new FormError('Cet enregistrement est deja présent'));
        }

        $view = $this->view($form, 200)
            ->setTemplate("MGNKDynDnsBundle:Api:newRecords.html.twig")
            ->setTemplateVar('form')
        ;
        return $this->handleView($view);
    }

    public function getZonesAction()
    {
        $data=$this->container->get('doctrine.orm.entity_manager')->getRepository('MGNKDynDnsBundle:Zone')->findAll();
        $view = $this->view($data, 200)
            ->setTemplate("MGNKDynDnsBundle:Api:getZones.html.twig")
            ->setTemplateVar('zones')
        ;

        return $this->handleView($view);
    }

    public function getZoneAction($id)
    {
        $data=$this->container->get('doctrine.orm.entity_manager')->getRepository('MGNKDynDnsBundle:Zone')->find($id);
        $view = $this->view($data, 200)
            ->setTemplate("MGNKDynDnsBundle:Api:getZone.html.twig")
            ->setTemplateVar('zone')
        ;

        return $this->handleView($view);
    }
}
