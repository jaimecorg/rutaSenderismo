<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\UsuarioType;
use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsuarioController extends AbstractController
{
    /**
     * @Route("/usuario", name="usuario_listar")
     */
    public function listar(UsuarioRepository $usuarioRepository) : Response
    {
        $usuarios = $usuarioRepository->findAllOrdenados();
        return $this->render('usuario/listar.html.twig', [
            'usuarios' => $usuarios
        ]);
    }

    /**
     * @Route("/usuario/nuevo", name="usuario_nuevo")
     */
    public function nuevo(Request $request, UsuarioRepository $usuarioRepository) : Response
    {
        $usuario = new Usuario();

        return $this->modificar($request, $usuarioRepository, $usuario);
    }

    /**
     * @Route("/usuario/{id}", name="usuario_modificar")
     */
    public function modificar(Request $request, UsuarioRepository $usuarioRepository, Usuario $usuario) : Response
    {
        //$this->denyAccessUnlessGranted('ROLE_MODERADOR');

        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $usuarioRepository->add($usuario);
                $this->addFlash('success', 'Cambios guardados con éxito');
                return $this->redirectToRoute('usuario_listar');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Error al guardar los cambios');
            }
        }

        return $this->render('usuario/modificar.html.twig', [
            'usuario' => $usuario,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/usuario/eliminar/{id}", name="usuario_eliminar")
     */
    public function eliminar(Request $request, UsuarioRepository $usuarioRepository, Usuario $usuario) : Response
    {
//        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($request->getMethod() === 'POST' && $request->get('confirmar') === 'ok') {
            try {
                $usuarioRepository->remove($usuario);
                $this->addFlash('success', 'Usuario eliminado con éxito');
                return $this->redirectToRoute('usuario_listar');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Error al eliminar el usuario');
            }
        }

        return $this->render('usuario/eliminar.html.twig', [
            'usuario' => $usuario
        ]);
    }
}