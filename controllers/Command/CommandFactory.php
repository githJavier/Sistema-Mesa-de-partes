<?php
// controllers/Command/CommandFactory.php

namespace Command;

require_once 'BaseCommand.php';

class CommandFactory {
    // Solo rutas RELATIVAS desde la raíz del proyecto web
    private static $controllerMap = [
        'administracionRemitentes' => 'controllers/Administracion/controlAdministracionRemitentes.php',
        'administracionUsuarios' => 'controllers/Administracion/controlAdministracionUsuarios.php',
        'administracionAreas' => 'controllers/Administracion/controlAdministracionAreas.php',
        'administracionDocumentos' => 'controllers/Administracion/controlAdministracionDocumentos.php',
        'consultarTramitesArchivados' => 'controllers/Consultar/controlFormConsultarTramitesArchivados.php',
        'consultarTramitesDerivados' => 'controllers/Consultar/controlFormConsultarTramitesDerivados.php',
        'recibirTramitesExternos' => 'controllers/RecibirTramiteExterno/controlFormRecibirTramiteExterno.php',
        'recibirTramitesInternos' => 'controllers/RecibirTramiteInterno/controlFormRecibirTramiteInterno.php',
        'resolverTramites' => 'controllers/ResolverTramite/controlFormResolverTramite.php',
        'ingresarTramite' => 'controllers/IngresarTramiteUsuario/controlFormIngresarTramiteUsuario.php',
        'mensajesAdmin' => 'controllers/Mensaje/controlFormMensajeAdmin.php'
    ];
    
    private static $viewMap = [
        'home' => 'views/dashboard/principalAdmin.php'
    ];
    
    public static function create(string $commandName, array $params = []): CommandInterface {
        $commandClass = self::getCommandClass($commandName);
        $params['commandName'] = $commandName;
        
        // Pasar ruta relativa, NO absoluta
        if (isset(self::$controllerMap[$commandName])) {
            $params['controllerPath'] = self::$controllerMap[$commandName];
        }
        
        if (isset(self::$viewMap[$commandName])) {
            $params['viewPath'] = self::$viewMap[$commandName];
        }
        
        return new $commandClass($params);
    }
    
    private static function getCommandClass(string $commandName): string {
        $map = [
            'home' => HomeCommand::class,
            'administracionRemitentes' => AdministrationCommand::class,
            'administracionUsuarios' => AdministrationCommand::class,
            'administracionAreas' => AdministrationCommand::class,
            'administracionDocumentos' => AdministrationCommand::class,
            'consultarTramitesArchivados' => ConsultationCommand::class,
            'consultarTramitesDerivados' => ConsultationCommand::class,
            'recibirTramitesExternos' => TramiteCommand::class,
            'recibirTramitesInternos' => TramiteCommand::class,
            'resolverTramites' => TramiteCommand::class,
            'ingresarTramite' => TramiteCommand::class,
            'mensajesAdmin' => MessageCommand::class
        ];
        
        if (!isset($map[$commandName])) {
            throw new \Exception("Comando no encontrado: {$commandName}");
        }
        
        return __NAMESPACE__ . '\\' . $map[$commandName];
    }
}

// Comandos concretos
class HomeCommand extends BaseCommand {
    public function execute(): array {
        return [
            'type' => 'direct_view',
            'view' => $this->params['viewPath'] ?? '',
            'command' => $this->params['commandName']
        ];
    }
}

class AdministrationCommand extends BaseCommand {
    public function execute(): array {
        return [
            'type' => 'ajax',
            'controller' => $this->params['controllerPath'] ?? '',
            'command' => $this->params['commandName']
        ];
    }
}

class TramiteCommand extends BaseCommand {
    public function execute(): array {
        return [
            'type' => 'ajax',
            'controller' => $this->params['controllerPath'] ?? '',
            'command' => $this->params['commandName']
        ];
    }
}

class ConsultationCommand extends BaseCommand {
    public function execute(): array {
        return [
            'type' => 'ajax',
            'controller' => $this->params['controllerPath'] ?? '',
            'command' => $this->params['commandName']
        ];
    }
}

class MessageCommand extends BaseCommand {
    public function execute(): array {
        return [
            'type' => 'ajax',
            'controller' => $this->params['controllerPath'] ?? '',
            'command' => $this->params['commandName']
        ];
    }
}