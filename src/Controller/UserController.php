<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\FicheEditType;
use App\Form\UserType;
use App\Service\UploaderHelper;
use Gedmo\Sluggable\Util\Urlizer;
use App\Repository\CalendarRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Cocur\Slugify\Slugify;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class UserController extends AbstractController
{
    /**
     * @Route("/{pseudo}/fiche", name="fiche_user")
     */
    public function dashboard(User $user): Response
    {
        $user->getPseudo();
        return $this->render('user/dashboard.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{pseudo}/fiche/admin-edit", name="admin_fiche_edit")
     */
    public function adminEdit(Request $request, UserInterface $user, EntityManagerInterface $em, UploaderHelper $uploaderHelper, UserRepository $userRepository, $pseudo): Response
    {
        $userToUpdate = $userRepository->findOneBy(['slug' => $pseudo]);
        if ($user->getRoles()[0] !== "ROLE_ADMIN") {
            throw new AccessDeniedException('POUR QUI TU TE PRENDS');
        }

        $form = $this->createForm(FicheEditType::class, $userToUpdate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($userToUpdate);
            $em->flush();
            $this->addFlash('message', 'Level/exp mis à jour');
            return $this->redirectToRoute('dashboard', [
                'pseudo' => $userToUpdate->getSlug()
            ]);
        }

        return $this->render('user/fiche-admin-edit.html.twig', [
            'user' => $userToUpdate,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("mon-compte/edit/", name="profil_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserInterface $user, EntityManagerInterface $em, UploaderHelper $uploaderHelper, UserRepository $userRepository): Response
    {
        $slugger = new Slugify();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                $profilData = $form->getData();
                /** @var UploadedFile $uploadedFile */
                $uploadedFile = $form['imageFile']->getData();
                if ($uploadedFile) {
                    $newFilename = $uploaderHelper->uploadAvatar($uploadedFile);
                    
                    $profilData->setProfilImage($newFilename);
                }
                
                $user->setSlug($slugger->slugify($user->getPseudo()));
                $em->persist($user);
                $em->flush();
                $this->addFlash('message', 'Profil mis à jour');
        }

        return $this->render('user/profil-edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/mot-de-passe/modifier", name="edit_password"), methods={"GET", "POST"})
     */
    public function editPass(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        if($request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager();

            $user = $this->getUser();

            if($request->request->get('pass') == $request->request->get('pass2')){
                $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('pass')));
                $em->flush();
                $this->addFlash('message', 'Mot de passe mis à jour avec succès');

                return $this->redirectToRoute('profil_edit');
            }else{
                $this->addFlash('error', 'Les deux mots de passe ne sont pas identiques');
            }
        }

        return $this->render('user/profil-edit-pass.html.twig', [

        ]);
    }
}
