<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;

/**
 * Portal Hola Mundo de CakePHP (framework real).
 */
class PortalController extends AppController
{
    /** Datos del portal. */
    private function portalData(): array
    {
        $FW = [
            'name'    => 'CakePHP',
            'tagline' => 'Veterano con filosofía "convención sobre configuración". Complejidad media pero contenida. Base de usuarios estable.',
            'accent'  => '#D33C44',
            'accent2' => '#B72F37',
            'site'    => 'https://cakephp.org',
            'kind'    => 'Framework real',
        ];
        $functions = [
            ['icon' => '🧭', 'title' => 'Enrutamiento', 'live' => true,
             'desc' => 'Rutas conectadas en config/routes.php (esta página y /api lo están).',
             'code' => "\$builder->connect('/saludo/*',\n    ['controller' => 'Portal', 'action' => 'saludo']);"],
            ['icon' => '🎨', 'title' => 'Vistas', 'live' => true,
             'desc' => 'Plantillas en templates/. Esta página se renderiza así.',
             'code' => "// templates/Portal/index.php\n\$this->set('nombre', \$nombre);"],
            ['icon' => '🔌', 'title' => 'API JSON', 'live' => true,
             'desc' => 'Respuesta JSON con el objeto Response. Aquí funciona de verdad.',
             'code' => "return \$this->response\n    ->withType('application/json')\n    ->withStringBody(json_encode(\$datos));",
             'link' => 'api', 'linkText' => 'Probar el endpoint JSON (ruta real /api) →'],
            ['icon' => '✅', 'title' => 'Validación', 'live' => true,
             'desc' => 'Validator de CakePHP. Aquí se valida un correo real.',
             'code' => "\$validator->email('email');",
             'form' => true],
            ['icon' => '🗄️', 'title' => 'ORM', 'live' => false,
             'desc' => 'ORM de CakePHP (Table/Entity) con convenciones claras.',
             'code' => "\$usuarios = \$this->Users->find()\n    ->where(['activo' => true])->all();"],
        ];
        $compare = [
            ['Symfony','Enterprise, modular','Alta','Alto (corporativo)','Proyectos grandes'],
            ['Laravel','Full-stack, todo incluido','Media-alta','Muy alto (#1)','Apps modernas'],
            ['Laminas','Modular corporativo','Alta','Bajo (en declive)','Legacy empresarial'],
            ['Yii2','Full-stack + Gii','Media','Medio (regional)','Apps rápidas'],
            ['CakePHP','Convención sobre config.','Media','Modesto/estable','CRUD clásico'],
            ['Phalcon','Extensión C, rapidísimo','Media-alta (setup)','Nicho','Rendimiento extremo'],
            ['CodeIgniter','Ligero, poca magia','Baja','Medio (bajando)','Proyectos pequeños'],
            ['Slim','Micro-framework','Baja','Nicho (por diseño)','APIs pequeñas'],
            ['Lumen','Micro-Laravel','Baja','En declive','Microservicios (obsoleto)'],
        ];
        return compact('FW', 'functions', 'compare');
    }

    public function index(): void
    {
        $this->viewBuilder()->disableAutoLayout();
        $d = $this->portalData();
        $formResult = null;
        $email = $this->request->getQuery('email');
        if ($email !== null) {
            $email = trim((string)$email);
            $ok = filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
            $formResult = $ok
                ? ['ok' => true,  'msg' => "✓ '$email' es un correo válido."]
                : ['ok' => false, 'msg' => "✗ '$email' no es un correo válido."];
        }
        $this->set($d + ['formResult' => $formResult]);
    }

    public function api(): Response
    {
        $FW = $this->portalData()['FW'];
        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode([
                'framework' => $FW['name'],
                'mensaje'   => 'Hola Mundo desde un endpoint JSON',
                'hora'      => date('c'),
                'ok'        => true,
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
