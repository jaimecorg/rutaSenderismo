<?php

namespace App\Controller;

use App\Entity\Ruta;
use App\Entity\Valoracion;
use App\Form\ValoracionType;
use App\Repository\ValoracionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ValoracionController extends AbstractController
{
    /**
     * @Route("/valoracion", name="valoracion_listar")
     */
    public function listar(ValoracionRepository $valoracionRepository) : Response
    {
        $this->denyAccessUnlessGranted('ROLE_MODERADOR');

        $valoraciones = $valoracionRepository->findAllOrdenadas();

        return $this->render('valoracion/listar.html.twig', [
            'valoraciones' => $valoraciones
        ]);
    }

    /**
     * @Route("/valoracion/nueva/{id}", name="valoracion_nueva")
     */
    public function nuevo(Request $request, ValoracionRepository $valoracionRepository, $id, Security $security): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USUARIO');

        $valoracion = new Valoracion();
        $valoracion->setFechaCreacion(new \DateTime()); // Establecer la fecha y hora actual

        $user = $security->getUser(); // Obtener el usuario autenticado

        // Establecer el ID del usuario actual en la valoración
        $valoracion->setUsuario($user);

        // Establecer el ID de la ruta según el parámetro proporcionado en la URL
        $rutaId = $id;
        // Obtener la ruta por su ID (puedes usar tu lógica o consulta para obtenerla)
        $ruta = $this->getDoctrine()->getRepository(Ruta::class)->find($rutaId);

        $valoracion->setRuta($ruta);

        return $this->modificar($request, $valoracionRepository, $valoracion);
    }

    /**
     * @Route("/valoracion/{id}", name="valoracion_modificar")
     */
    public function modificar(Request $request, ValoracionRepository $valoracionRepository, Valoracion $valoracion) : Response
    {
        $this->denyAccessUnlessGranted('ROLE_MODERADOR');

        $form = $this->createForm(ValoracionType::class, $valoracion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $valoracionRepository->add($valoracion);
                $this->addFlash('success', 'Cambios guardados con éxito');
                return $this->redirectToRoute('ruta_listar_detalle');
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
        $this->denyAccessUnlessGranted('ROLE_MODERADOR');

        if ($request->getMethod() === 'POST' && $request->get('confirmar') === 'ok') {
            try {
                $valoracionRepository->remove($valoracion);
                $this->addFlash('success', 'Valoración eliminada con éxito');
                return $this->redirectToRoute('principal');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Error al eliminar la valoración');
            }
        }

        return $this->render('valoracion/eliminar.html.twig', [
            'valoracion' => $valoracion
        ]);
    }
}