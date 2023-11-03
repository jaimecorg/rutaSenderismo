<?php

namespace App\Controller;

use App\Entity\Ruta;
use App\Form\RutaType;
use App\Repository\RutaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RutaController extends AbstractController
{
    /**
     * @Route("/ruta", name="ruta_listar")
     */
    public function listar(RutaRepository $rutaRepository) : Response
    {
        $rutas = $rutaRepository->findAllOrdenadas();
        return $this->render('ruta/listar.html.twig', [
            'rutas' => $rutas
        ]);
    }

    /**
     * @Route("/ruta/nueva", name="ruta_nueva")
     */
    public function nuevo(Request $request, RutaRepository $rutaRepository) : Response
    {
        $ruta = new Ruta();

        return $this->modificar($request, $rutaRepository, $ruta);
    }

    /**
     * @Route("/ruta/{id}", name="ruta_modificar")
     */
    public function modificar(Request $request, RutaRepository $rutaRepository, Ruta $ruta) : Response
    {
        //$this->denyAccessUnlessGranted('ROLE_MODERADOR');

        $form = $this->createForm(RutaType::class, $ruta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $rutaRepository->add($ruta);
                $this->addFlash('success', 'Cambios guardados con éxito');
                return $this->redirectToRoute('ruta_listar');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Error al guardar los cambios');
            }
        }

        return $this->render('ruta/modificar.html.twig', [
            'ruta' => $ruta,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/ruta/eliminar/{id}", name="ruta_eliminar")
     */
    public function eliminar(Request $request, RutaRepository $rutaRepository, Ruta $ruta) : Response
    {
//        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($request->getMethod() === 'POST' && $request->get('confirmar') === 'ok') {
            try {
                $rutaRepository->remove($ruta);
                $this->addFlash('success', 'Ruta eliminada con éxito');
                return $this->redirectToRoute('ruta_listar');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Error al eliminar la ruta');
            }
        }

        return $this->render('ruta/eliminar.html.twig', [
            'ruta' => $ruta
        ]);
    }
}