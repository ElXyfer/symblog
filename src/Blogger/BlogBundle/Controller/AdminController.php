<?php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function viewAction()
    {

        $entityManager = $this->getDoctrine()->getManager();

        $allUsers = $entityManager->getRepository('BloggerBlogBundle:User')->findAll();


        return $this->render('BloggerBlogBundle:Admin:view.html.twig', ['allUsers' => $allUsers]);
    }

    public function editAction($id, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
                $user = $entityManager->getRepository('BloggerBlogBundle:User')->find($id);

                $form = $this->createForm(PostType::class, $user, [
                        'action' => $request->getUri()
                        ]);

                $form->handleRequest($request);


                if($form->isValid()){

                    $entityManager->flush();
                    return $this->redirect($this->generateUrl('admin_user_view',
                            ['id' => $user->getId()]));
         }

         return $this->render('BloggerBlogBundle:Admin:edit.html.twig', [
                    'form' => $form->createView(),
                    'user' => $user
                    ]);
    }

    public function deleteAction()
    {
        return $this->render('BloggerBlogBundle:Admin:delete.html.twig', array(
            // ...
        ));
    }

}
