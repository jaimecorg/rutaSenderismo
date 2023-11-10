<?php

namespace App\Controller;

use App\Entity\Valoracion;
use App\Form\ValoracionType;
use App\Repository\ValoracionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ValoracionController extends AbstractController
{
    /**
     * @Route("/valoracion", name="valoracion_listar")
     */
    public function listar(ValoracionRepository $valoracionRepository) : Response
    {
        $valoraciones = $valoracionRepository->findAllOrdenadas();
        return $this->render('valoracion/listar.html.twig', [
            'valoraciones' => $valoraciones
        ]);
    }

    /**
     * @Route("/valoracion/nueva", name="valoracion_nueva")
     */
    public function nuevo(Request $request, ValoracionRepository $valoracionRepository) : Response
    {
        $valoracion = new Valoracion();

        return $this->modificar($request, $valoracionRepository, $valoracion);
    }

    /**
     * @Route("/valoracion/{id}", name="valoracion_modificar")
     */
    public function modificar(Request $request, ValoracionRepository $valoracionRepository, Valoracion $valoracion) : Response
    {
        //$this->denyAccessUnlessGranted('ROLE_MODERADOR');

        $form = $this->createForm(ValoracionType::class, $valoracion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $valoracionRepository->add($valoracion);
                $this->addFlash('success', 'Cambios guardados con éxito');
                return $this->redirectToRoute('valoracion_listar');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Error al guardar los cambios');
            }
        }

        return $this->render('valoracion/modificar.html.twig', [
            'valoracion' => $valoracion,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/valoracion/eliminar/{id}", name="valoracion_eliminar")
     */
    public function eliminar(Request $request, ValoracionRepository $valoracionRepository, Valoracion $valoracion) : Response
    {
//        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($request->getMethod() === 'POST' && $request->get('confirmar') === 'ok') {
            try {
                $valoracionRepository->remove($valoracion);
                $this->addFlash('success', 'Valoración eliminada con éxito');
                return $this->redirectToRoute('valoracion_listar');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Error al eliminar la valoración');
            }
        }

        return $this->render('valoracion/eliminar.html.twig', [
            'valoracion' => $valoracion
        ]);
    }
}