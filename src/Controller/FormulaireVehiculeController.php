<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Vehicules;
use App\Form\VehiculeFormType;
use App\Entity\Proprietaires;

class FormulaireVehiculeController extends AbstractController
{
    #[Route('/vehicule/ajoutVehicule', name: 'app_formulaire_ajoutVehicule')]
    public function renseignerInfo(Request $request, EntityManagerInterface $entMan): Response
    {
        // if ($this->getUser() === null) {
        //     return $this->redirectToRoute('app_login');
        // }
        // $currentUser = $this->getUser();

        $vehicule = new Vehicules();
        $proprietaries = new Proprietaires();


        $form = $this->createForm(VehiculeFormType::class, $vehicule);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$vehicule->setProprietaire($proprietaries);
            
            $entMan->persist($vehicule);
            $entMan->flush();


            return $this->redirectToRoute('app_formulaire_ajoutVehicule');
        }

        return $this->render('formulaire_vehicule/index.html.twig', [
            'controller_name' => 'FormulaireVehiculeController',
            'vehiculeForm' => $form->createView(),
            'vehicule' => $vehicule,
        ]);
    }
}
