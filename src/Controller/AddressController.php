<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Address;
use App\Form\Type\AddressType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\SearchForm;

class AddressController extends AbstractController {

    #[Route('/showall',
            name: 'address_showall',
            methods:['GET']
        )]
    public function showall(Request $request): Response {
        $col = $request->query->get('col');
        $order = $request->query->get('order');
        $addresses = $this->getDoctrine()->getRepository(Address::class)->findBy([], [$col => $order]);

        return $this->render('address/showall.html.twig', [
                    'addresses' => $addresses,
        ]);
    }

    #[Route('/search',
                name: 'address_search',
                methods:['GET','POST']
        )]
    public function search(Request $request): Response {
        $col = $request->query->get('col');
        if($col == null)
            $col = 'id'; //default value for column name
        $order = $request->query->get('order');
        if($order == null)
            $order = 'DESC'; //default value for order
//       $form = $this->createForm(SearchType::class);//without suchen button
        $searchForm = new SearchForm();
        $form = $this->createFormBuilder($searchForm, ['attr' => ['class' => 'd-flex'],])
                ->setAction($this->generateUrl('address_search'))
                ->setMethod('GET')
                ->add('keyword', TextType::class, [
                    'attr' => ['class' => 'form-control me-sm-2',
                        'placeholder' => 'Suche',
                    ],
                    'label' => false,
                ])
                ->add('Suchen', SubmitType::class, [
                    'attr' => ['class' => 'btn btn-info my-2 my-sm-0'],
                ])
                ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $keyword = $form->getData()->getKeyword();
            $entityManager = $this->getDoctrine()->getManager();
            $addresses = $entityManager->getRepository(Address::class)->findByKeyword($keyword, $col, $order);
            return $this->render('address/searchResult.html.twig', [
                        'addresses' => $addresses,
                        'keyword' => $keyword,
            ]);
        }
        return $this->render('address/search.html.twig', [
                    'form' => $form->createView(),
        ]);
    }

    #[Route('/add',
                name: 'address_add')]
    public function add(Request $request): Response {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            $address = $form->getData();

            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($address);
            $entityManager->flush();

            return $this->redirectToRoute('address_success', ['operation' => 'add']);
        }
        return $this->render('address/new.html.twig', [
                    'form' => $form->createView(),
        ]);
    }

    #[Route('delete/{id}',
                name: 'address_delete')]
    public function delete($id, Request $request): Response {
        $entityManager = $this->getDoctrine()->getManager();
        $address = $entityManager->getRepository(Address::class)->find($id);
        if (!$address) {
            throw $this->createNotFoundException(
                            'Keine Adresse mit ID ' . $id . 'wurde gefunden.'
            );
        }
        $entityManager->remove($address);
        $entityManager->flush();
        return $this->redirectToRoute('address_success', ['operation' => 'delete']);
    }

    #[Route('/update/{id}',
                name: 'address_update')]
    public function update($id, Request $request): Response {
        $entityManager = $this->getDoctrine()->getManager();
        $address = $entityManager->getRepository(Address::class)->find($id);
        if (!$address) {
            throw $this->createNotFoundException(
                            'Keine Adresse mit ID ' . $id . 'wurde gefunden.'
            );
        }
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            $address = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($address);
            $entityManager->flush();

            return $this->redirectToRoute('address_success', ['operation' => 'update']);
        }
        return $this->render('address/new.html.twig', [
                    'form' => $form->createView(),
        ]);
    }

    #[Route('/success/{operation}',
                name: 'address_success')]
    public function success($operation): Response {
        switch ($operation) {
            case 'add': $operation = 'gespeichert';
                break;
            case 'update': $operation = 'geändert';
                break;
            case 'delete': $operation = 'gelöscht';
                break;
            default: $operation = 'nicht geändert';
        }
        return $this->render('address/success.html.twig', [
                    'operation' => $operation,
        ]);
    }

}
