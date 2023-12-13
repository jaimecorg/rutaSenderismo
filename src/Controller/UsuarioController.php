<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\NuevoUsuarioType;
use App\Form\PerfilType;
use App\Form\UsuarioType;
use App\Repository\UsuarioRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsuarioController extends AbstractController
{
    /**
     * @Route("/usuario", name="usuario_listar")
     * @Security("is_granted('ROLE_ADMIN')")
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
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function nuevo(Request $request, UsuarioRepository $usuarioRepository) : Response
    {
        $usuario = new Usuario();

        return $this->modificar($request, $usuarioRepository, $usuario);
    }

    /**
     * @Route("/usuario/crear", name="usuario_crear_perfil")
     */
    public function crearPerfil(Request $request, UsuarioRepository $usuarioRepository) : Response
    {
        $usuario = new Usuario();

        return $this->modificarUsuario($request, $usuarioRepository, $usuario);
    }

    /**
     * @Route("/usuario/{id}", name="usuario_modificar")
     * @Security("is_granted('ROLE_ADMIN')")
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
     * @Security("is_granted('ROLE_ADMIN')")
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



    /**
     * @Route("/usuario/perfil/{id}", name="usuario_modificar_perfil")
     */
    public function modificarPerfil(Request $request, UsuarioRepository $usuarioRepository, Usuario $usuario) : Response
    {
        $form = $this->createForm(PerfilType::class, $usuario);
        $form->handleRequest($request);

        // Obtener todas las rutas del usuario
        $rutasUsuario = $usuario->getRutas();

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $usuarioRepository->add($usuario);
                $this->addFlash('success', 'Cambios guardados con éxito');
                return $this->redirectToRoute('usuario_modificar_perfil');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Error al guardar los cambios');
            }
        }

        return $this->render('usuario/perfil.html.twig', [
            'usuario' => $usuario,
            'form' => $form->createView(),
            'rutasUsuario' => $rutasUsuario
        ]);
    }



    /**
     * @Route("/usuario/modificar/{id}", name="usuario_modificar_usuario")
     */
    public function modificarUsuario(Request $request, UsuarioRepository $usuarioRepository, Usuario $usuario) : Response
    {
        $form = $this->createForm(NuevoUsuarioType::class, $usuario);
        $form->handleRequest($request);

        $usuario->setPermisos('permisos');
        $usuario->setModerador(0);
        $usuario->setAdministrador(0);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $usuarioRepository->add($usuario);
                $this->addFlash('success', 'Cambios guardados con éxito');
                return $this->redirectToRoute('principal');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Error al guardar los cambios');
            }
        }

        return $this->render('usuario/registarUsuario.html.twig', [
            'usuario' => $usuario,
            'form' => $form->createView(),
        ]);
    }
}