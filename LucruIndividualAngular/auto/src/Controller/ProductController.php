<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductController extends AbstractController
{
    #[Route('/product/view/{id}', name: 'app_product_single')]
    public function getProduct(int $id, ProductRepository $productRepository): Response
    {
        $product = $productRepository->find($id);

        if (!$product) {
            throw new NotFoundHttpException("Product with id {$id} not found!");
        }

        return $this->render('product/single.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/product/{page<\d+>}', name: 'app_product_list', defaults: ['page' => 0], methods: ["GET"])]
    public function getProductList(int $page, ProductRepository $productRepository): Response
    {
        $offset = max(0, $page);
        $products = $productRepository->getProductPaginator($offset);

        return $this->render('product/list.html.twig', [
            'products' => $products,
            'previous'  => $offset - ProductRepository::PAGINATOR_PER_PAGE,
            'next'      => min(count($products), $offset + ProductRepository::PAGINATOR_PER_PAGE),
        ]);
    }

    #[Route('/product/create', name: 'app_product_create', methods: ["GET", "POST"])]
    public function createProduct(Request $request, ProductRepository $productRepository, SluggerInterface $slugger, LoggerInterface $logger): Response
    {
        $product = new Product();
        $productForm = $this->createForm(ProductType::class, $product);
        $productForm->handleRequest($request);

        // Handle Form
        if ($productForm->isSubmitted() && $productForm->isValid()) {

            /** @var UploadedFile $image */
            $product = $productForm->getData();
            $image = $productForm->get('image')->getData();

            if ($image) {
                $safeFilename = $slugger->slug($product->getName());
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();

                try {
                    $image->move($this->getParameter('image_directory'), $newFilename);
                } catch (FileException $e) {
                    $logger->warning($e);
                    $this->addFlash('error', 'Something went wrong, please try again later!');
                    $this->redirectToRoute('app_product_create');
                }

                $product->setImageUrl($this->getParameter('image_path') . $newFilename);
            } else {
                $product->setImageUrl($this->getParameter('image_path') . 'not-found.png');
            }

            $productRepository->save($product, true);

            return $this->redirectToRoute('app_product_single', ['id' => $product->getId()]);
        }

        return $this->renderForm('product/form.html.twig', [
            'product' => $product,
            'form' => $productForm,
        ]);
    }

    #[Route('/product/update/{id}', name: 'app_product_update', methods: ["GET", "POST"])]
    public function updateProduct(int $id, Request $request, ProductRepository $productRepository, SluggerInterface $slugger, LoggerInterface $logger): Response
    {
        $product = $productRepository->find($id);
        $productForm = $this->createForm(ProductType::class, $product);
        $productForm->handleRequest($request);

        // Handle Form
        if ($productForm->isSubmitted() && $productForm->isValid()) {

            $oldImage = $product->getImageUrl();

            /** @var UploadedFile $image */
            $product = $productForm->getData();
            $image = $productForm->get('image')->getData();

            if ($image) {

                if ($oldImage !== $this->getParameter('image_path') . 'not-found.png') {
                    $fileSystem = new Filesystem();
                    $fileSystem->remove($this->getParameter('public_dir') . $oldImage);
                }

                $safeFilename = $slugger->slug($product->getName());
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();

                try {
                    $image->move($this->getParameter('image_directory'), $newFilename);
                } catch (FileException $e) {
                    $logger->warning($e);
                    $this->addFlash('error', 'Something went wrong, please try again later!');
                    $this->redirectToRoute('app_product_create');
                }

                $product->setImageUrl($this->getParameter('image_path') . $newFilename);
            }

            $this->addFlash('success', 'Product succefully saved!');
            $productRepository->save($product, true);

            return $this->redirectToRoute('app_product_update', ['id' => $product->getId()]);
        }

        return $this->renderForm('product/form.html.twig', [
            'product' => $product,
            'form' => $productForm,
        ]);
    }
}
