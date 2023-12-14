<?php

namespace App\Controller;

use App\Entity\Ruta;
use App\Form\RutaType;
use App\Repository\RutaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

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
    public function nuevo(Request $request, RutaRepository $rutaRepository, Security $security): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USUARIO');
        $ruta = new Ruta();

        // Obtener el usuario autenticado
        $usuario = $security->getUser();

        // Asignar el usuario a la nueva ruta
        if ($usuario !== null) {
            $ruta->setUsuario($usuario);
        }

        return $this->modificar($request, $rutaRepository, $ruta);
    }

    /**
     * @Route("/ruta/{id}", name="ruta_modificar")
     */
    public function modificar(Request $request, RutaRepository $rutaRepository, Ruta $ruta) : Response
    {
        $this->denyAccessUnlessGranted('ROLE_MODERADOR');

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
        if ($request->getMethod() === 'POST' && $request->get('confirmar') === 'ok') {
            try {
                $rutaRepository->remove($ruta);
                $this->addFlash('success', 'Ruta eliminada con éxito');
                return $this->redirectToRoute('ruta_listar_detalle');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Error al eliminar la ruta');
            }
        }

        return $this->render('ruta/eliminar.html.twig', [
            'ruta' => $ruta
        ]);
    }

    /**
     * @Route("/rutaDetalle", name="ruta_listar_detalle")
     */
    public function listarDetalle(RutaRepository $rutaRepository) : Response
    {
        $rutas = $rutaRepository->findAllOrdenadas();
        return $this->render('ruta/listadoDetalle.html.twig', [
            'rutas' => $rutas
        ]);
    }

    /**
     * @Route("/ruta/info/{id}", name="ruta_info")
     */
    public function info(RutaRepository $rutaRepository, $id) : Response
    {
        $ruta = $rutaRepository->find($id);

        if (!$ruta) {
            throw new NotFoundHttpException('La ruta no fue encontrada');
        }

        // Obtener las valoraciones de la ruta
        $valoraciones = $ruta->getValoraciones();
        $imagenes = $ruta->getImagenes();

        return $this->render('ruta/listadoInfo.html.twig', [
            'ruta' => $ruta,
            'valoraciones' => $valoraciones,
            'imagenes' => $imagenes,
        ]);
    }
}