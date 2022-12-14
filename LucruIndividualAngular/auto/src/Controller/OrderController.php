<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\Product;
use App\Form\OrderProductType;
use App\Form\OrderType;
use App\Repository\OrderProductRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use DateTime;
use DateTimeImmutable;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[Route('/order/view/{id}', name: 'app_order_single')]
    public function getOrder(int $id, OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->find($id);

        if (!$order) {
            throw new NotFoundHttpException("Order with id {$id} Not Found!");
        }

        return $this->render('order/single.html.twig', [
            'order' => $order,
        ]);
    }

    #[Route('/order', name: 'app_order_list')]
    public function getAllOrders(OrderRepository $orderRepository): Response
    {
        $orders = $orderRepository->findAll();

        return $this->render('order/list.html.twig', [
            'orders' => $orders,
        ]);
    }

    #[Route('/order/create', name: 'app_order_create')]
    public function createOrder(Request $request, OrderRepository $orderRepository): Response
    {
        $order = new Order();
        $orderForm = $this->createForm(OrderType::class, $order);

        $orderForm->handleRequest($request);

        if ($orderForm->isSubmitted() && $orderForm->isValid()) {
            /** @var Order $order */
            $order = $orderForm->getData();
            $order->setCreatedAt(new DateTimeImmutable());

            $orderRepository->save($order, true);
            return $this->redirectToRoute('app_order_single', ['id' => $order->getId()]);
        }

        return $this->renderForm('order/form.html.twig', [
            'order' => $order,
            'form' => $orderForm,
        ]);
    }

    #[Route('/order/update/{id}', name: 'app_order_update')]
    public function updateOrder(int $id, Request $request, OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->find($id);
        $orderForm = $this->createForm(OrderType::class, $order);

        $orderForm->handleRequest($request);

        if ($orderForm->isSubmitted() && $orderForm->isValid()) {
            /** @var Order $order */
            $order = $orderForm->getData();
            $order->setCreatedAt(new DateTimeImmutable());

            $orderRepository->save($order, true);
            $this->addFlash('success', 'Order succefully saved!');
            return $this->redirectToRoute('app_order_update', ['id' => $order->getId()]);
        }

        return $this->renderForm('order/form.html.twig', [
            'order' => $order,
            'form' => $orderForm,
        ]);
    }

    #[Route('/order/product/create', name: 'app_order_product_create', methods: ["POST", "GET"])]
    public function createOrderProduct(Request $request, OrderProductRepository $orderProductRepository, ProductRepository $productRepository, OrderRepository $orderRepository, LoggerInterface $logger): Response
    {
        $orderProduct = new OrderProduct();

        if ($pId = $request->get('p')) {
            $product = $productRepository->find($pId);
            if ($product) {
                $orderProduct->setProduct($product);
            }
        }

        if ($oId = $request->get('o')) {
            $order = $orderRepository->find($oId);
            if ($order) {
                $orderProduct->setOrd($order);
            }
        }

        $orderProductForm = $this->createForm(OrderProductType::class, $orderProduct);

        $orderProductForm->handleRequest($request);

        if ($orderProductForm->isSubmitted() && $orderProductForm->isValid()) {
            $order = $orderProductForm->get('ord')->getData();
            $product = $orderProductForm->get('product')->getData();
            $count = $orderProductForm->get('count')->getData();
            $add_count = $orderProductForm->get('add_count')->getData();

            $orderProduct = $orderProductRepository->findOneByOrderAndProduct($order->getId(), $product->getId());

            if (!$orderProduct) {
                $orderProduct = $orderProductForm->getData();
                $this->addFlash('success', "Product `{$orderProduct->getProduct()->getName()}` added to Order `{$orderProduct->getOrd()->getId()}`");
            } else {
                $add_count ? $orderProduct->addCount($count) : $orderProduct->setCount($count);
                $this->addFlash('success', "Product `{$orderProduct->getProduct()->getName()}` already in order " . ($add_count ? 'added' : 'set') . " count: `{$count}`");
            }

            $orderProductRepository->save($orderProduct, true);
        }

        return $this->renderForm('order/add_product_form.html.twig', [
            'form' => $orderProductForm,
        ]);
    }

    // #[Route('/order/product/delete/{id<\d+>}', name: 'app_order_product_create', methods: ["POST", "GET"])]
    // public function deleteOrderProduct(int $id, OrderProductRepository $orderProductRepository): Response
    // {

    //     $orderProductRepository->remove();

    //     return $this->redirectToRoute('app_single_order', ['id' => $id]);
    // }
}
