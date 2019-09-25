<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product", name="product.")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function index(ProductRepository $productRepository)
    {
        $products = $productRepository->findAll();

        return $this->render('product/index.html.twig', compact('products'));
    }

    /**
     * @Route("/create", name="create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function create(Request $request)
    {
        $product = new Product();

        $product->setName('product name');

        // entity manager
        $em = $this->getDoctrine()->getManager();

        $em->persist($product);
        $em->flush();

        return $this->redirect($this->generateUrl('product.index'));
    }

    /**
     * @Route("/show/{id}", name="show")
     * @param Product $product
     * @return Response
     */
    public function show(Product $product)
    {
        return $this->render('product/show.html.twig', compact('product'));
    }

    /**
     * @Route("/delete/{id}", name="delete")
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function remove(Product $product)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();

        $this->addFlash('success', 'Product was deleted.');

        return $this->redirect($this->generateUrl('product.index'));
    }
}
