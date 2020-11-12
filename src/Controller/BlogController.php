<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Blogdata;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use App\Service\FileUploader;
use Knp\Component\Pager\PaginatorInterface;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog/{blogId}", name="blog",methods={"GET","POST"})
     */
    public function index(Request $request,FileUploader $fileUploader,int $blogId = 0): Response
    {
        // this is main function
        if (!$this->getUser()) {
            return $this->redirectToRoute('login');
        }
            $blog = new Blogdata();
            $blogsdata = array();
            $loggedInUser = $this->getUser(); 
            $form = $this->createFormBuilder($blog)
                ->add('title', TextType::class)
                ->add('blog_data', TextareaType::class)
                ->add('category', TextType::class)
                ->add('image_path', FileType::class, [
                    
                    'constraints' => [
                        new File([
                            'mimeTypes' => [
                                'image/png','image/jpg','image/jpeg',
                            ],
                            'mimeTypesMessage' => 'Please upload a valid Image File',
                        ])
                    ],
                ])
                ->add('save', SubmitType::class, ['label' => 'Create Blog'])
                ->getForm();

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                    $data = $form->getData();

                    $file = $form['image_path']->getData(); 
                    
                    if ($file) {
                        $fileName = $fileUploader->upload($file);
                        $blog->setImagePath($fileName);
                    }
                
                if($blogId){
                    // Edit Case For Blog ///
                    $entityManager = $this->getDoctrine()->getManager();
                    $blogRepository = $this->getDoctrine()->getRepository(Blogdata::class);
                    $blogs = $blogRepository->findBlog($blogId);
                    
                    $blogs->setTitle($data->getTitle());
                    $blogs->setBlogData($data->getBlogData());
                    $blogs->setCategory($data->getCategory());
                    $blogs->setImagePath($fileName);
                    $blogs->setUpdatedOn(date_create(date('d-m-Y H:i:s')));
                    $entityManager->flush();
                    $this->addFlash('success', 'Your Blog updated Successfully !!');
                    return $this->redirectToRoute('blogslist');
                }else{
                    
                    // ADD CASE FOR BLOG 
                    $date = new \DateTime('@'.strtotime('now')); 
                    $blog->setCreatedBy($loggedInUser);
                    //$blog->setDeleteStatus(0);
                    $blog->setCreatedOn(date_create(date('d-m-Y H:i:s')));
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($data);
                    $entityManager->flush();   
                    $this->addFlash('success', 'Your Blog Added Successfully !!');
                }
                    if($blog->getId()){
                    return $this->redirectToRoute('blogslist');
                    }

            }
            if($blogId){
                $blogRepository = $this->getDoctrine()->getRepository(Blogdata::class);
                $blogsdata = $blogRepository->getBlogById($blogId,$loggedInUser->getId());
            }
            return $this->render('blog/index.html.twig', [
                'form'     => $form->createView(),
                'username' => $loggedInUser->getUsername(),
                'blogData' => $blogsdata
            ]);
        
    }
    
     /**
    * @Route("/bloglist", name="blogslist")
    */
    public function usersBlogList(PaginatorInterface $paginator,Request $request)
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $blogRepository = $this->getDoctrine()->getRepository(Blogdata::class);
        $blogsdata = $blogRepository->getBlogsByUser($this->getUser()->getId());
        $blogdata = $paginator->paginate( $blogsdata,$request->query->getInt('page', 1),2);
        //dd($blogdata);
        return  $this->render('blog/list.html.twig',[
            'blogs' => $blogdata,
            'profile' => $this->getUser(),
            'imagePath' => $this->getParameter('blog_directory')
        ]);
    }
    /**
    * @Route("/blog/remove/{blogId}", name="blogs_remove")
    */
    public function RemoveBlog(int $blogId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $blogRepository = $this->getDoctrine()->getRepository(Blogdata::class);
        $blogs = $blogRepository->findBlog($blogId);
        $entityManager->remove($blogs);
        $entityManager->flush();
        $this->addFlash('success', 'Your Blog Deleted Successfully !!');
        return $this->redirectToRoute('blogslist');
    }


}