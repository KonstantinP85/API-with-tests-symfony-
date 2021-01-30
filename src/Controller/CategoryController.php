<?php


namespace App\Controller;


use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends BaseController
{
    /**
     * @Route ("v3.0/category", name="category")
     * @return Response
     */
    public function indexAction()
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->respond($category);

    }

    /**
     * @Route ("v3.0/category/create", name="category_create")
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->submit($request->request->all());
        if (!$form->isValid())
        {
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }
        $this->getDoctrine()->getManager()->persist($category);
        $this->getDoctrine()->getManager()->flush();

        return $this->respond($category);
    }
}